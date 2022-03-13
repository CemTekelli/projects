CREATE OR REPLACE package body 
ABSIS.BO_DOCUSIGN as


LEV_DEBUG CONSTANT NUMBER :=1;
LEV_INFO CONSTANT NUMBER := 2;
LEV_WARNING CONSTANT NUMBER :=3;
LEV_ERROR CONSTANT NUMBER := 4;
LEV_FATAL CONSTANT NUMBER := 5;

is_envid varchar2(36);
is_log_session_name generic_log.gl_session_name%TYPE;


FUNCTION escape(theString IN VARCHAR2, theAsciiOutput IN BOOLEAN DEFAULT TRUE, theEscapeSolitus IN BOOLEAN DEFAULT FALSE) RETURN VARCHAR2
IS
	sb							VARCHAR2(32767) := '';
	buf							VARCHAR2(64);
	num							NUMBER;
BEGIN
	IF (theString IS NULL) THEN
		RETURN '';
	END IF;

	FOR I IN 1 .. LENGTH(theString) LOOP
		buf := SUBSTR(theString, i, 1);

		CASE buf
		WHEN CHR(8)  THEN buf := '\b';	--	backspace b = U+0008 = chr(8)
		WHEN CHR(9)  THEN buf := '\t';	--	tabulator t = U+0009 = chr(9)
		WHEN CHR(10) THEN buf := '\n';	--	newline   n = U+000A = chr(10)
		WHEN CHR(12) THEN buf := '\f';	--	formfeed  f = U+000C = chr(12)
		WHEN CHR(13) THEN buf := '\r';	--	carret    r = U+000D = chr(13)
		WHEN CHR(34) THEN buf := '\"';
		WHEN CHR(47) THEN				--	slash
			IF (theEscapeSolitus) THEN
				buf := '\/';
			END IF;
		WHEN CHR(92) THEN buf := '\\';	--	backslash
		ELSE
			IF (ASCII(buf) < 32) THEN
				buf := '\u' || REPLACE(SUBSTR(TO_CHAR(ASCII(buf), 'XXXX'), 2, 4), ' ', '0');
			ELSIF (theAsciiOutput) then
				buf := REPLACE(ASCIISTR(buf), '\', '\u');
			END IF;
		END CASE;

		sb := sb || buf;
	END LOOP;

	RETURN sb;
END escape;

PROCEDURE p_log(an_severity        IN generic_log.gl_severity%TYPE,
                as_default_message IN generic_log.gl_default_message%TYPE,
                as_key             IN generic_log.gl_glm_key%TYPE,
                as_argument_string IN VARCHAR2                           := NULL)
IS
    ln_ret          NUMBER(12);
    ls_old_log_session_name generic_log.gl_session_name%TYPE;
BEGIN

    ls_old_log_session_name := bo_log_manager.is_session_name;
    --bo_log_manager.set_session_name(is_log_session_name);
    ln_ret := bo_log_manager.add_log(an_severity, as_default_message, 'BO_DOCUSIGN', as_key, 8, as_argument_string);
    bo_log_manager.set_session_name(ls_old_log_session_name);

END p_log;

FUNCTION f_process_connect_event(an_dsce_pk number) return number IS
/** Process a Docusign Connect notification received by the edition.layout.webhook_listener.webservice
* @param an_dsce_pk pk of the notification stored in DS_CONNECT_EVENT by the webservice
* @return : currently unused
*/

ls_env_status varchar2(100);
ln_decoded_status number;
r_env ABSIS.DS_ENVELOPE%ROWTYPE;
ln_vp number;
ln_specifiv_vp number;
ls_vp_function_name ABSIS.VALIDATION_PROCEDURE.VP_FUNCTION_NAME%TYPE;
ls_backtrace           VARCHAR2(4000); 
ls_error           VARCHAR2(4000);
ln_ret number;
ls_decline_reason VARCHAR2(500);
ls_voided_reason  VARCHAR(500);



CURSOR signers IS 
SELECT * FROM
    DS_CONNECT_EVENT,
    JSON_TABLE (DSCE_PAYLOAD,'$.recipients.signers[*]'
    COLUMNS ( recipient_id number PATH '$.recipientId',
              status VARCHAR2(100) PATH '$.status',
              recipient_email varchar2(1000) PATH '$.email',
              deliv_date DATE PATH '$.deliveredDateTime',
              signed_date DATE PATH '$.signedDateTime',
              declined_date DATE PATH '$.declinedDateTime',
              decline_reason VARCHAR2(500) PATH '$.declinedReason',
              voided_reason VARCHAR(500) PATH '$.voidedReason',
              voided_date DATE PATH '$.voidedDateTime'
              ))
     WHERE dsce_pk = an_dsce_pk;
BEGIN

    is_log_session_name :=  'BO_DOSCUSIGN_F_PROCESS_CONNECT_EVENT_'||TO_CHAR(an_dsce_pk);

    SELECT 
        dsce.DSCE_PAYLOAD.envelopeId,
        dsce.DSCE_PAYLOAD.status,
        dsce.DSCE_PAYLOAD.voidedReason
     INTO is_envid, ls_env_status, ls_voided_reason
     FROM ABSIS.DS_CONNECT_EVENT dsce
     WHERE DSCE_PK = an_dsce_pk;
     
     SELECT * INTO r_env 
     FROM ABSIS.DS_ENVELOPE
     WHERE dsen_dsign_envid = is_envid;

     IF SQL%ROWCOUNT = 0 THEN
        p_log(LEV_ERROR,'No envelope found for envid '||is_envid,'BODS_ERR_01','#1;'||is_envid||'#');
     ELSE  
        IF lower(ls_env_status) = 'voided' then 
          update absis.ds_envelope set dsen_status = 40, dsen_comment = ls_voided_reason
            where dsen_pk = r_env.dsen_pk;
          insert into ds_env_history(DSEH_STATUS, DSEH_PK, DSEH_DSEN_FK, DSEH_DATE, DSEH_COMMENT)
          select 40, sq_dseh_pk.nextval, r_env.dsen_pk, sysdate, ls_voided_reason from dual;
          ln_vp := to_number(netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ENV_SIGN_VOID_VP'));
          if ln_vp is not null then 

            select vp_function_name into ls_vp_function_name from ABSIS.validation_procedure where vp_pk = ln_vp;

            EXECUTE IMMEDIATE 'BEGIN :r := ' || ls_vp_function_name || '(:a); END;' using OUT ln_ret, IN r_env.dsen_pk;
            if ln_ret < 0 then 
              p_log(LEV_ERROR, 'callback method ls_vp_function_name (envelope voided) returned' || to_char(ln_ret), 'BODS_ERR_02', '#1;' || to_char(ln_ret) || '#');
            end if;
          end if;
        END IF;
        IF lower(ls_env_status) = 'declined' then 
          update absis.ds_envelope set dsen_status = 30
            where dsen_pk = r_env.dsen_pk;
          insert into ds_env_history(DSEH_STATUS, DSEH_PK, DSEH_DSEN_FK, DSEH_DATE) 
            select 30, sq_dseh_pk.nextval, r_env.dsen_pk, sysdate from dual;
            ln_vp := to_number(netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ENV_SIGN_REJECTS_VP'));
            if ln_vp is not null then 

              select vp_function_name into ls_vp_function_name from ABSIS.validation_procedure where vp_pk = ln_vp;

              EXECUTE IMMEDIATE 'BEGIN :r := ' || ls_vp_function_name || '(:a); END;' using OUT ln_ret, IN r_env.dsen_pk;
                if ln_ret < 0 then 
                    p_log(LEV_ERROR,'callback method  ls_vp_function_name (envelope rejected) returned '||to_char(ln_ret),'BODS_ERR_02','#1;'||to_char(ln_ret)||'#');
                end if;   
            end if;
        end if; 
        IF lower(ls_env_status) = 'completed' THEN
        
            UPDATE ABSIS.ds_envelope SET dsen_status = 20
            WHERE dsen_pk = r_env.dsen_pk;

           insert into ds_env_history (DSEH_STATUS, DSEH_PK, DSEH_DSEN_FK, DSEH_DATE)
                select 20, sq_dseh_pk.nextval,r_env.dsen_pk,sysdate from dual;            
        
            ln_vp := to_number(netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ENV_COMPLETED_VP'));
            IF ln_vp is not null THEN
                
                SELECT vp_function_name 
                INTO ls_vp_function_name 
                FROM ABSIS.validation_procedure 
                WHERE vp_pk = ln_vp;
                
                EXECUTE IMMEDIATE 'BEGIN :r := ' || ls_vp_function_name || '(:a); END;' using OUT ln_ret, IN r_env.dsen_pk;
                if ln_ret < 0 then 
                    p_log(LEV_ERROR,'callback method  ls_vp_function_name (envelope completed) returned '||to_char(ln_ret),'BODS_ERR_02','#1;'||to_char(ln_ret)||'#');
                end if;                  
            END IF;
        END IF;
                
         -- if specific vp to be called for tha specific envelope , call it 
        IF r_env.dsen_status_vp_fk is not null THEN
            SELECT vp_function_name 
            INTO ls_vp_function_name 
            FROM ABSIS.validation_procedure   
            WHERE vp_pk = r_env.dsen_status_vp_fk;
            
            SELECT decode (lower(ls_env_status),'declined',30,'completed',20,'sent',15)
            into ln_decoded_status
            from dual;
            
            EXECUTE IMMEDIATE ls_vp_function_name||' ('||TO_CHAR(r_env.dsen_pk)||','||TO_CHAR(r_env.dsen_status)||','||TO_CHAR(ln_decoded_status)||');';     
        END IF; 
       
    END IF;

    -- boucle sur signers pour mise à jour statuts de signature
    FOR rec IN signers LOOP

        IF rec.status = 'completed' THEN
             UPDATE ABSIS.DS_ENV_SIGNER SET DSES_STATUS = 20 , DSES_SIGN_DATE = rec.signed_date, dses_deliv_date = NVL(dses_deliv_date, rec.deliv_date)
                WHERE DSES_EMAIL = rec.recipient_email
                AND DSES_DSEN_FK in (SELECT dsen_pk FROM DS_ENVELOPE WHERE DSEN_DSIGN_ENVID = is_envid);
        ELSIF rec.status in ('sent','delivered') THEN
             UPDATE ABSIS.DS_ENV_SIGNER set DSES_STATUS = 10 , DSES_DELIV_DATE = sysdate
                WHERE DSES_EMAIL = rec.recipient_email
                AND DSES_DSEN_FK in (SELECT DSEN_PK FROM DS_ENVELOPE WHERE DSEN_DSIGN_ENVID = is_envid);
        ELSIF rec.status = 'declined' THEN 
              UPDATE ABSIS.DS_ENV_SIGNER SET DSES_STATUS = 30 , DSES_SIGN_DATE = rec.declined_date, dses_deliv_date = NVL(dses_deliv_date, rec.deliv_date)
                WHERE DSES_EMAIL = rec.recipient_email
                AND DSES_DSEN_FK in (SELECT DSEN_PK FROM DS_ENVELOPE WHERE DSEN_DSIGN_ENVID = is_envid);
              UPDATE ABSIS.DS_ENV_SIGNER SET DSES_COMMENT = rec.decline_reason where DSES_EMAIL = rec.recipient_email and dses_dsen_fk in (SELECT DSEN_PK FROM DS_ENVELOPE WHERE DSEN_DSIGN_ENVID = is_envid);
        ELSIF rec.status = 'voided' THEN 
          UPDATE ABSIS.DS_ENV_SIGNER SET DSES_STATUS = 40, dses_deliv_date = NVL(dses_deliv_date, rec.deliv_date)
            WHERE DSES_EMAIL = rec.recipient_email
            AND DSES_DSEN_FK in (SELECT DSEN_PK FROM DS_ENVELOPE WHERE DSEN_DSIGN_ENVID = is_envid);
        END IF;    
    END LOOP;
    
    return 0;

    EXCEPTION
       WHEN others THEN
         BEGIN
           -- Oracle 10g only : detailed stack trace
            EXECUTE IMMEDIATE 'select DBMS_UTILITY.FORMAT_ERROR_BACKTRACE from dual'
               INTO ls_backtrace;
            EXCEPTION
                WHEN OTHERS THEN
                   ls_backtrace := '';
            END;

            ls_error := DBMS_UTILITY.format_error_stack || ls_backtrace;
            p_log (LEV_FATAL,ls_error,'BODS_EXCEPTION','#1;'|| ls_error || '#');
            return -1;
              
END f_process_connect_event;


function get_epoch(p_attime in date default sysdate) return number
IS
BEGIN
  return ROUND((p_attime - to_date('1-1-1970 00:00:00','MM-DD-YYYY HH24:Mi:SS')) * 24 * 60 * 60);
end get_epoch;

function get_wsel_pk(as_wse_code varchar2, as_wse_url varchar2, as_wsel_requestbody varchar2) return number
IS
  ln_wse_pk number;
  ln_wsel_pk number;
BEGIN
  BEGIN
    select WSE_PK into ln_wse_pk
    from WEBSERVICE_EXT
    where WSE_CODE = as_wse_code
    and WSE_URL = as_wse_url;
  EXCEPTION WHEN NO_DATA_FOUND THEN
      ln_wse_pk := null;
  END;
  --dbms_output.put_line('ln_wse_pk:' || ln_wse_pk);
  if ln_wse_pk is null then
    ln_wse_pk := SQ_WSE_PK.nextval;
    insert into WEBSERVICE_EXT(WSE_PK, WSE_CODE, WSE_URL, WSE_REQUEST_METHOD, WSE_AUTHENTIFICATION_TYPE, WSE_CONTENT_TYPE)
    values(ln_wse_pk, as_wse_code, as_wse_url, 'POST', 'OAJWTAG', 'application/json');
    --commit;
  else
    update WEBSERVICE_EXT
    set WSE_AUTHENTIFICATION_TYPE = 'OAJWTAG'
    where WSE_PK = ln_wse_pk;
  end if;

  ln_wsel_pk := SQ_WSEL_PK.nextval;
  insert into WEBSERVICE_EXT_LOG(WSEL_PK, WSEL_WSE_FK, WSEL_REQUESTBODY)
  values(ln_wsel_pk, ln_wse_pk, as_wsel_requestbody);

  return ln_wsel_pk;
END get_wsel_pk;

function get_signers(an_dsdo_pk number) return json_array_t
IS
  signer_obj json_object_t;
  signers_arr json_array_t;
  dsds_dses_fk DS_DOC_SIGNER.DSDS_DSES_FK%TYPE;
  env_signer_rec DS_ENV_SIGNER%ROWTYPE;
  CURSOR c_signers IS
      select DSDS_DSES_FK
      from DS_DOC_SIGNER
      where DSDS_DSDO_FK = an_dsdo_pk;
BEGIN
  signers_arr := json_array_t();
  OPEN c_signers;
  LOOP
  FETCH c_signers into dsds_dses_fk;
    EXIT WHEN c_signers%notfound;
    signer_obj := json_object_t();
    select * into env_signer_rec
    from DS_ENV_SIGNER
    where DSES_PK = dsds_dses_fk;
    signer_obj.put('email', env_signer_rec.DSES_EMAIL);
    signer_obj.put('name', env_signer_rec.DSES_NAME);
    signer_obj.put('roleName', env_signer_rec.DSES_ROLE_NAME);
    signer_obj.put('recipientID', env_signer_rec.DSES_RECIPIENT_ID);
    signers_arr.append(signer_obj);
  END LOOP;
  CLOSE c_signers; 

  return signers_arr;
END get_signers;

function get_after_vp return number
IS
  ln_vp_pk number;
  ls_vp_function_name varchar2(150);
  ls_vp_name varchar2(150);
  ln_ct_pk number;
BEGIN
  select CT_PK
  into ln_ct_pk
  from context_tables
  where CT_REFERENCE_ID = 231;
    
  ls_vp_function_name := 'BO_DOCUSIGN.afterSubmitEnvelope';
  ls_vp_name := ls_vp_function_name;

  BEGIN
  select VP_PK
  into ln_vp_pk
  from validation_procedure
  where VP_FUNCTION_NAME = ls_vp_function_name
  and VP_CT_FK = ln_ct_pk;
  EXCEPTION WHEN NO_DATA_FOUND THEN
    ln_vp_pk := null;
  END;

  if ln_vp_pk is null then
    ln_vp_pk := SQ_VP_PK.nextval;
    insert into validation_procedure(VP_PK, VP_CT_FK, VP_SCHEMA,VP_FUNCTION_NAME, VP_NAME,vp_type)
    values(ln_vp_pk, ln_ct_pk,'ABSIS', ls_vp_function_name, ls_vp_name,9);
  end if;
  return ln_vp_pk;
END get_after_vp;

function submitEnvelope (an_dsen_pk number) return number
IS
  env_rec DS_ENVELOPE%ROWTYPE;
  doc_rec DS_DOCUMENT%ROWTYPE;
  filename edm_document.EDMDOC_FILE_NAME%TYPE;
  content_obj json_object_t;
  composite_obj json_object_t;
  composites_arr json_array_t;
  inlineTemplate_obj json_object_t;
  inlineTemplates_arr json_array_t;
  document_obj json_object_t;
  recipients_obj json_object_t;
  signers_arr json_array_t;
  ln_index number;
  ls_url varchar2(2000);
  ln_wsel_pk number(12);
  ln_njsj_pk number(12);
  ln_njp_pk number(12);
  ls_header varchar2(100);
  ln_iat number;
  ls_payload varchar2(300);
  ls_admin_base_uri varchar2(4000);
  ls_privatekey varchar2(4000);
  ln_ret number;
  ln_vp_pk number;
  ls_dbname varchar2(1000);
  CURSOR c_document IS
      select *
      from DS_DOCUMENT
      where DSDO_DSEN_FK = an_dsen_pk;
BEGIN

  -- security test : prevent submit if D name parameter is not as expected 
  
  SELECT ora_database_name INTO ls_dbname FROM dual;
  IF ls_dbname <> netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_CHECK_DBNAME') THEN
       p_log(LEV_ERROR,'DOCUSIGN envelope submit forbidden because parameter 8/DOCUSIGN/DOCUSIGN_CHECK_DBNAME does not match ORA_DATABASE_NAME','BODS_ERR_03');
       return -1;    
  END IF;
 

  composites_arr := json_array_t();
  OPEN c_document;
  LOOP
  FETCH c_document into doc_rec;
      EXIT WHEN c_document%notfound;
      composite_obj := json_object_t();
	  document_obj := json_object_t();
      
      document_obj.put('documentId', doc_rec.DSDO_PK);
      
      select EDMDOC_FILE_NAME into filename
      from edm_document
      where EDMDOC_PK = doc_rec.DSDO_EDMDOC_FK;
      
      document_obj.put('name', filename);
      ln_index := INSTR(filename, '.', -1);
      if ln_index = 0 then
        document_obj.put('fileExtension', '');
      else
        document_obj.put('fileExtension', SUBSTR(filename, ln_index + 1));
      end if;
      document_obj.put('documentBase64', '#EDMDOCB64-' || doc_rec.DSDO_EDMDOC_FK || '#');
--      dbms_output.put_line (json_array_t('[{
--        "sequence": "1",
--        "templateId": "' || doc_rec.DSDO_SERVER_TEMPL_ID || '"' ||
--      '}]').stringify);
      --dbms_output.put_line (get_signers(doc_rec.DSDO_PK).stringify);
	  composite_obj.put('document', document_obj);
      signers_arr := get_signers(doc_rec.DSDO_PK);
      --signers_arr := json_array_t('[{"email":"gerard.deschepper@netika.com","name":"G\00E9rard1 Deschepper","roleName":"CUSTOMER1","recipientID":"1"},{"email":"gdeschepper@netika.com","name":"G\00E9rard2 Deschepper","roleName":"SUPPLIER1","recipientID":"2"}]');
      recipients_obj := json_object_t();
      recipients_obj.put ('signers', signers_arr);
      inlineTemplate_obj := json_object_t();
      inlineTemplate_obj.put ('recipients',recipients_obj);
      inlineTemplate_obj.put ('sequence','2');
      --dbms_output.put_line (inlineTemplates_obj.stringify);
      composite_obj.put('serverTemplates', json_array_t('[{
        "sequence": "1",
        "templateId": "' || doc_rec.DSDO_SERVER_TEMPL_ID || '"' ||
      '}]'));
      --dbms_output.put_line (inlineTemplates_obj.stringify);
      inlineTemplates_arr := json_array_t();
      inlineTemplates_arr.append(inlineTemplate_obj);
      composite_obj.put('inlineTemplates', json_array_t(inlineTemplates_arr));
      composites_arr.append(composite_obj);
  END LOOP;
  CLOSE c_document; 

  select * into env_rec
  from DS_ENVELOPE where DSEN_PK = an_dsen_pk;
  content_obj := json_object_t();
  content_obj.put('emailBlurb', escape(env_rec.DSEN_EMAIL_BLURB));
  content_obj.put('emailSubject', escape(env_rec.DSEN_EMAIL_SUBJECT));
  content_obj.put('status', 'sent');
  content_obj.put('compositeTemplates', composites_arr);

  ls_url := netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ACCOUNT_BASE_URI') || '/' ||
            netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ACCOUNT_ID') || '/' ||
            netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ENVELOPE_SERVICE');
  
  -- replace des \\ par \ dans stringify parce que json_object.put escape les \ introduits par la fonction escape...
  ln_wsel_pk := get_wsel_pk('DSSE_'||to_char(an_dsen_pk)||'_'||to_char(systimestamp,'SS.FF3'), ls_url, replace (content_obj.stringify,'\\','\'));
  
    -- set dsen_pk in bo_env with setRecordPk for later use in job after_vp
  ln_ret := bo_env.setRecordPk(an_dsen_pk);
  
  
  --dbms_output.put_line('ln_wsel_pk:' || ln_wsel_pk);
  ln_njsj_pk := bo_njs.f_create_job('DS_SUBMIT_' || ln_wsel_pk,  '', 'com.absisgroup.rei.jobs.RESTWS', '', to_date(NULL), '', to_date(NULL), 'BO_DOCUSIGN.submitEnvelope', 'JAVA');
  --DBMS_OUTPUT.put_line('p_create_job: ' || ln_njsj_pk);

  -- Set BO_DOCUSIGN.afterSubmitEnvelope as a after_vp for the job
  ln_vp_pk := get_after_vp;
  update njs_jobs
  set njsj_after_vp_fk = ln_vp_pk
  WHERE njsj_pk = ln_njsj_pk;
  


  -- set job parameters  
  ln_ret := bo_njs.f_set_param(ln_njsj_pk, 'wselPk', ln_wsel_pk, false);
													  
  ls_header := json_object('alg'  value 'RS256', 'typ'  value 'JWT');
  ln_ret := bo_njs.f_set_param(ln_njsj_pk, 'JWT_REQ_HEADER', ls_header, false);
															   											   
  ln_iat := get_epoch;
  ls_payload := json_object(
    'iss'   value netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_INTEGRATION_KEY'),
    'sub'   value netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_USER_ID'),
    'scope' value 'impersonation signature',
    'aud'   value netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_AUD'),
    'exp'   value to_char(ln_iat + 3600),
    'iat'   value to_char(ln_iat)
  );
  ln_ret := bo_njs.f_set_param(ln_njsj_pk, 'JWT_REQ_PAYLOAD', ls_payload, false);
												   
  ls_admin_base_uri := netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ADMIN_BASE_URI');
																				 
  ln_ret := bo_njs.f_set_param(ln_njsj_pk, 'JWT_REQ_URL', ls_admin_base_uri, false);
  ls_privatekey := netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_PRIVATE_KEY');
  ln_ret := bo_njs.f_set_param(ln_njsj_pk, 'JWT_REQ_PRIVATE_KEY', ls_privatekey, false);

  bo_njs.p_enable_job(ln_njsj_pk);
  --DBMS_OUTPUT.put_line('p_enable_job: ' || ln_njsj_pk);
		   
  return 1;
END submitEnvelope;

Function afterSubmitEnvelope (an_njsj_pk number, an_return number) return number
IS
  ln_dsen_pk number;
  ln_vp_pk number;
  ls_function_name VARCHAR2(201);
  ln_ret number;
  lclob_submit_answer CLOB;
  ljson_submit_answer json_object_t;
  ls_envelope_id varchar2(36) := null;
  lr_param v_njs_jobs_param%ROWTYPE;
  lc_resp clob;
  
BEGIN
    
 
  
  ln_dsen_pk := bo_env.getRecordPk;
  
  p_log(LEV_DEBUG,'in after',6666);
  p_log(LEV_DEBUG,'record pk : '||to_char(ln_dsen_pk),6666);
  
  if an_return < 0 then
    update DS_ENVELOPE
    set DSEN_STATUS = -1
    where DSEN_PK = ln_dsen_pk;
  else
    update DS_ENVELOPE
    set DSEN_STATUS = 10
    where DSEN_PK = ln_dsen_pk;
    
    insert into ds_env_history (DSEH_STATUS, DSEH_PK, DSEH_DSEN_FK, DSEH_DATE)
                select 10, sq_dseh_pk.nextval,ln_dsen_pk,sysdate from dual;
    
    

    select DSEN_STATUS_VP_FK
    into ln_vp_pk
    from DS_ENVELOPE
    where DSEN_PK = ln_dsen_pk;
    
    if ln_vp_pk is not null then
      SELECT DECODE(NVL(vp_schema,'EMPTY'), 'EMPTY', '', vp_schema || '.') || vp_function_name
      INTO ls_function_name
      FROM validation_procedure
      WHERE vp_pk = ln_vp_pk;

      EXECUTE IMMEDIATE 'BEGIN :ln_ret := ' || ls_function_name || '(:dsen_pk, 0, 10); END;' using OUT ln_ret, ln_dsen_pk;
    end if;
    
    -- récupération de la réponse de soulission à docusign et report dans ds_envelope
    lr_param := bo_njs.f_get_param(an_njsj_pk,'WSELPK');
    
    select WSEL_RESPONSE 
    into lc_resp
    from webservice_ext_log where WSEL_pk = lr_param.number_val;
    
    update ds_envelope set DSEN_SUBMIT_ANSWER = lc_resp where dsen_pk = ln_dsen_pk;
    
        
    if lc_resp is not null then
      ljson_submit_answer := json_object_t(lc_resp);
      ls_envelope_id := ljson_submit_answer.get_string('envelopeId');
    end if;

    update DS_ENVELOPE
    set DSEN_DSIGN_ENVID = ls_envelope_id
    where DSEN_PK = ln_dsen_pk;
  end if;

  return 1;
END afterSubmitEnvelope;

/** Send a "RI object" to docusign , creating a DS_ENVELOPE with proper DS_DOCUMENT-s and DS_SIGNER-s and submit it to docusign with submitEnvelope - by now only designed for purchase orders 
* @param an_record_pk : pk of the object to be processed
* @param as_context : "context" identifying type of object - As this is used to match EDMTR_CONTEXTE, the supported values are exact uppercase oracle table names by now , on ly 'COMMITMENT' is supported
* @return : à préciser !
*/
FUNCTION F_SEND_OBJECT(an_record_pk IN NUMBER, as_context varchar2) RETURN NUMBER
IS 
    ln_count              NUMBER;
    ln_dsen_pk            ABSIS.DS_ENVELOPE.dsen_pk%TYPE;
    ln_trs_sg_pk          ABSIS.TIERS_SIEGES.trs_sg_pk%TYPE;
    ln_brmo_dset_fk       ABSIS.BROADCAST_MODE.BRMO_DSET_FK%TYPE;
    ln_dsdo_pk            ABSIS.DS_DOCUMENT.dsdo_pk%TYPE;
    ln_ret                NUMBER;
    ln_co_brmo_fk         ABSIS.COMMITMENT.CO_BRMO_FK%TYPE;
    ls_dset_email_subject ABSIS.DS_ENV_TEMPLATE.DSET_EMAIL_SUBJECT%TYPE;   
    ls_dset_email_blurb   ABSIS.DS_ENV_TEMPLATE.DSET_EMAIL_BLURB%TYPE;
    ln_role_suffix        NUMBER;
    ls_blurb              ABSIS.DS_ENVELOPE.DSEN_EMAIL_BLURB%TYPE;
    ls_co_reference       ABSIS.COMMITMENT.CO_REFERENCE%TYPE;
    ls_co_comment         ABSIS.COMMITMENT.CO_COMMENT%TYPE;
    ln_amount             NUMBER;
BEGIN


    CASE 
        WHEN as_context = 'COMMITMENT' THEN 
            SELECT  CO_BRMO_FK, BRMO_DSET_FK ,  dset_email_subject, dset_email_blurb, co_reference, co_comment , bp_commitment_line.getTotalAmount(co_pk)
            INTO ln_co_brmo_fk, ln_brmo_dset_fk, ls_dset_email_subject, ls_dset_email_blurb, ls_co_reference, ls_co_comment, ln_amount
            FROM    COMMITMENT, 
            BROADCAST_MODE,
            ds_env_template
            WHERE   CO_PK = an_record_pk AND 
                    CO_BRMO_FK = BRMO_PK AND 
                    brmo_dset_fk = dset_pk;

                ln_dsen_pk := sq_DSEN_PK.NEXTVAL;
                
                ls_blurb := nvl( ls_dset_email_blurb, netika_utility.fwk_param.getparam('8/DOCUSIGN/DOCUSIGN_ORDER_EMAIL_BLURB'));
                -- substitution des variables
                ls_blurb := replace (ls_blurb,'//REF//',ls_co_reference);
                ls_blurb := replace (ls_blurb,'//DESCRIPTION//', ls_co_comment);
                ls_blurb := replace (ls_blurb,'//AMOUNT//', to_char(ln_amount,'FM9999999999999999999999999999999999999990.99'));
                
                p_log(LEV_DEBUG,'set blurb in env :  '||ls_blurb ,'BODS_ERR_99','');
                p_log(LEV_DEBUG,'with escape  :  '||escape(ls_blurb) ,'BODS_ERR_99','');
                p_log(LEV_DEBUG,'with escape true true :  '||escape(ls_blurb,true,true) ,'BODS_ERR_99','');

                INSERT INTO DS_ENVELOPE (DSEN_PK,
                                        DSEN_DSET_FK,
                                        DSEN_EMAIL_SUBJECT,
                                        DSEN_EMAIL_BLURB,
                                        DSEN_STATUS,
                                        DSEN_STATUS_VP_FK,
                                        DSEN_CONTEXT,
                                        DSEN_RECORD_PK)
                                        VALUES( ln_dsen_pk,
                                                ln_brmo_dset_fk,
                                                nvl( ls_dset_email_subject, netika_utility.fwk_param.getparam('8/DOCUSIGN/DOCUSIGN_ORDER_EMAIL_SUBJECT')),
                                                ls_blurb,
                                                0,
                                                NULL,
                                                as_context,
                                                an_record_Pk
                                                );
                
                insert into ds_env_history (DSEH_STATUS, DSEH_PK, DSEH_DSEN_FK, DSEH_DATE)
                select 0, sq_dseh_pk.nextval,ln_dsen_pk,sysdate from dual;
                 
                FOR i IN (SELECT * FROM DS_ENV_TEMPLATE, 
                                        DS_TEMPL_SIGNER 
                                        WHERE   dset_pk = ln_brmo_dset_fk AND 
                                                DSTS_DSET_FK = DSET_PK AND 
                                                DSTS_MATCH_RANK = 0 )
                        LOOP 
                        IF i.DSTS_FIXED_EMAIL IS NOT NULL THEN 
                                INSERT INTO DS_ENV_SIGNER (DSES_PK,
                                                        DSES_DSEN_FK,
                                                        DSES_DSTS_FK,
                                                        DSES_ROLE_NAME,
                                                        DSES_RECIPIENT_ID,
                                                        DSES_NAME,
                                                        DSES_EMAIL,
                                                        DSES_STATUS
                                                        )
                                                        SELECT sq_DSES_PK.NEXTVAL,
                                                                ln_dsen_pk,
                                                                i.DSTS_PK,
                                                                i.DSTS_ROLE_NAME,
                                                                i.DSTS_RECIPIENT_ID,
                                                                i.DSTS_FIXED_NAME,
                                                                i.DSTS_FIXED_EMAIL,
                                                                0
                                                                FROM DUAL;
                        ELSE 
                            -- IDENTIFICATION DU TIERS FOURNISSEUR ACTUEL
                            SELECT trs_sg_pk INTO ln_trs_sg_pk 
                            FROM    COMMITMENT_PARTY,
                                    CO_PARTY_TYPE, 
                                    TIERS_SIEGES  
                                    WHERE   CO_PART_COPARTT_FK = COPARTT_PK AND 
                                            COPARTT_STEREOTYPE = 2 AND 
                                            CO_PART_TRS_SG_FK = TRS_SG_PK AND 
                                            CO_PART_CO_FK = an_record_pk; --AND 
                                            --trunc(sysdate) BETWEEN co_part_start_date AND NVL(co_part_end_date, trunc(sysdate);
                            ln_role_suffix := 1;
                            
                            INSERT INTO DS_ENV_SIGNER ( DSES_PK,
                                                            DSES_DSEN_FK,
                                                            DSES_DSTS_FK,
                                                            DSES_ROLE_NAME,
                                                            DSES_RECIPIENT_ID,
                                                            DSES_NAME,
                                                            DSES_EMAIL,
                                                            DSES_STATUS)
                            SELECT  sq_DSES_PK.NEXTVAL,
                                    ln_dsen_pk,
                                    i.DSTS_PK,
                                    i.DSTS_ROLE_NAME||to_char(ln_role_suffix),
                                    i.DSTS_RECIPIENT_ID,
                                    trs_sg_nom, 
                                    trs_sg_email, 
                                    0
                                    FROM    TIERS_SIEGES, 
                                            USAGE_REFERENCE, 
                                            USAGE_CODE
                                            WHERE   TRS_SG_PK = ln_trs_sg_pk                AND 
                                                    UCR_RECORD_FK = TRS_SG_PK               AND 
                                                    UCR_TABLE_CODE = 'TIERS_SIEGES'         AND 
                                                    trunc(sysdate) BETWEEN UCR_START_DATE AND NVL(UCR_END_DATE, trunc(sysdate)) AND 
                                                    UCR_UC_FK = UC_PK AND UC_CODE = netika_utility.fwk_param.getparam('8/DOCUSIGN/DOCUSIGN_ORDER_RECIPIENT_USAGE');
                                                    
                            IF SQL%ROWCOUNT > 0 THEN
                                ln_role_suffix := 2;
                            END IF;
                                                                                        
                            FOR contact in (SELECT sq_DSES_PK.NEXTVAL dses_pk,
                                                                    ln_dsen_pk dsen_pk,
                                                                    i.DSTS_PK dsts_pk,
                                                                    i.DSTS_ROLE_NAME dsts_role_name,
                                                                    i.DSTS_RECIPIENT_ID + 1000 * (rank() over(order by trs_cont_pk)) RECIPIENT_ID,
                                                                    DECODE(trs_cont_prenom, NULL, TRS_CONT_NOM, TRS_CONT_PRENOM || ' ' || trs_cont_nom ) FULL_NAME,
                                                                    trs_cont_email EMAIL
                                                                    FROM    TIERS_SIEGES, 
                                                                            TIERS_CONTACTS, 
                                                                            USAGE_REFERENCE, 
                                                                            USAGE_CODE
                                                                            WHERE   TRS_SG_PK = ln_trs_sg_pk            AND 
                                                                                    trs_cont_trs_sg_fk = trs_sg_pk      AND 
                                                                                    UCR_RECORD_FK = TRS_CONT_PK         AND 
                                                                                    UCR_TABLE_CODE = 'TIERS_CONTACTS'   AND 
                                                                                    trunc(sysdate) BETWEEN UCR_START_DATE AND NVL(UCR_END_DATE, trunc(sysdate)) AND 
                                                                                    UCR_UC_FK = UC_PK AND UC_CODE = netika_utility.fwk_param.getparam('8/DOCUSIGN/DOCUSIGN_ORDER_RECIPIENT_USAGE')) loop
                                INSERT INTO DS_ENV_SIGNER ( DSES_PK,
                                                            DSES_DSEN_FK,
                                                            DSES_DSTS_FK,
                                                            DSES_ROLE_NAME,
                                                            DSES_RECIPIENT_ID,
                                                            DSES_NAME,
                                                            DSES_EMAIL,
                                                            DSES_STATUS 
                                                            ) VALUES (
                                                                   contact.DSES_PK,
                                                                   contact.DSEN_PK,
                                                                   contact.DSTS_PK,
                                                                   contact.DSTS_ROLE_NAME||to_char(ln_role_suffix),
                                                                   contact.RECIPIENT_ID,
                                                                   contact.FULL_NAME,
                                                                   contact.EMAIL,
                                                                   0);

                              ln_role_suffix := ln_role_suffix +1;
                            END LOOP;
                        END IF;
                END LOOP; 
                -- QUAND NOUS SOMMES DANS LA SEQUENCE ( QUAND LE MATCH RANK EST > 0 )
                -- Parcours des signataire de la séquence de l'engagement - pour chacun, on évalue si le gnataire de ce niveau de séquence est repris dans les signataires du template
                FOR coa IN (SELECT * FROM   COMMITMENT_APPROVAL coa1, 
                                                USERS 
                                                WHERE   coa_co_fk = an_record_pk    AND 
                                                        COA_IS_DOCUSIGN = 1         AND 
                                                        coa_stamp_usr_fk = usr_pk   AND 
                                                        coa_cycle = (SELECT MAX(coa_cycle) FROM commitment_approval coa2 where coa2.coa_co_fk = coa1.coa_co_fk)
                                                        order by COA_LEVEL)
                LOOP 
                        INSERT INTO DS_ENV_SIGNER (DSES_PK,
                        DSES_DSEN_FK,
                        DSES_DSTS_FK,
                        DSES_ROLE_NAME,
                        DSES_RECIPIENT_ID,
                        DSES_NAME,
                        DSES_EMAIL,
                        DSES_STATUS
                        )
                        SELECT SQ_DSES_PK.NEXTVAL,
                                ln_dsen_pk,
                                DSTS_PK,
                                DSTS_ROLE_NAME,
                                DSTS_RECIPIENT_ID,
                                coa.USR_FIRST_NAME || ' ' || coa.USR_LAST_NAME,
                                coa.USR_EMAIL,
                                0
                                FROM DS_TEMPL_SIGNER
                                WHERE   DSTS_DSET_FK= ln_brmo_dset_fk AND
                                        DSTS_MATCH_RANK = coa.COA_LEVEL;
                END LOOP;
                -- ASSOCIATION DES DOCUMENT A L'ENVEVELOPE
                FOR dstd IN (SELECT * FROM ds_templ_document WHERE DSTD_DSET_FK = ln_brmo_dset_fk)
                        LOOP 
                        ln_dsdo_pk := sq_dsdo_pk.NEXTVAL;
                        INSERT INTO DS_DOCUMENT(DSDO_PK, 
                                                DSDO_DSEN_FK, 
                                                DSDO_DSTD_FK, 
                                                DSDO_SERVER_TEMPL_ID, 
                                                DSDO_EDMDOC_FK)
                                                SELECT  ln_dsdo_pk,
                                                        ln_dsen_pk,
                                                        dstd.dstd_pk,
                                                        dstd.dstd_server_templ_id,
                                                        edmdoc_pk
                                                        FROM EDM_DOCUMENT, EDM_REFERENCE 
                                                        WHERE   edmdoc_pk = edmref_edmdoc_fk 
                                                                AND edmref_context = 'COMMITMENT' 
                                                                AND edmref_record_pk = an_record_pk 
                                                                AND edmref_typeref_fk = dstd.dstd_typeref_fk;
                        INSERT INTO DS_DOC_SIGNER(  DSDS_PK, 
                                                        DSDS_DSES_FK, 
                                                        DSDS_DSDO_FK)   
                                                        SELECT  sq_dsds_pk.NEXTVAL, 
                                                                dses_pk, ln_dsdo_pk   
                                                                FROM    ds_templ_doc_signer, 
                                                                        DS_TEMPL_SIGNER,
                                                                        ds_env_signer
                                                                        WHERE   DSTDS_DSTD_FK = dstd.dstd_pk    AND 
                                                                                DSTDS_DSTS_FK = DSTS_PK AND
                                                                                DSES_DSTS_FK  = DSTS_PK  AND 
                                                                                DSES_DSEN_FK = ln_dsen_pk AND
                                                                                DSTS_DSET_FK = ln_brmo_dset_fk;


                        END LOOP;
    END CASE;
    ln_ret := BO_DOCUSIGN.submitEnvelope(ln_dsen_pk);
    If ln_ret < 0 THEN  
        return ln_ret ; 
    END IF;

    RETURN 1;
END F_SEND_OBJECT;

FUNCTION F_ORDER_WFSSC_TO_25_DOCUSIGN(an_record_Pk NUMBER, an_user_Pk NUMBER, an_wfs_Pk NUMBER, anIgnoreWarning IN NUMBER) RETURN NUMBER
IS 
    ln_ret            NUMBER; 
    ln_docusignable   NUMBER;
BEGIN 
    ln_docusignable := F_CHECK_ORDER_IS_DOCUSIGNABLE(an_record_pk, anIgnoreWarning, TRUE);
    if ln_docusignable <= 0 then 
      return ln_docusignable;
    else
      ln_ret := BO_DOCUSIGN.F_SEND_OBJECT(an_record_pk, 'COMMITMENT');
      IF ln_ret < 0 THEN 
          RETURN ln_ret;
      END IF;
       UPDATE commitment SET CO_AMENDMENT_STATUS = 5 where co_pk = an_record_Pk; 
    end if;
    RETURN 1;
END F_ORDER_WFSSC_TO_25_DOCUSIGN;


/** Check if order must be broadcast by docusign
* @param an_co_pk : order pk
* @return : 1 if order is docusign managed ; 0 if order is not docusign managed
*/
FUNCTION F_IS_ORDER_DOCUSIGN_MANAGED (an_co_pk IN NUMBER) return number 
IS
brmo ABSIS.BROADCAST_MODE%ROWTYPE;
BEGIN
  SELECT b.* INTO brmo
  FROM ABSIS.BROADCAST_MODE b, commitment 
  WHERE CO_PK = an_co_pk AND CO_brmo_fk = brmo_pk;
  
  if brmo.brmo_send_method = 1 then 
    return 1;
  else
    return 0;
  end if;

  exception 
  WHEN no_data_found then
    return 0;

END F_IS_ORDER_DOCUSIGN_MANAGED;

/** Check if order is complete for docusign management
* @param an_co_pk : order pk
* @param ab_checkDoc : if ab_checkDoc is TRUE we check if a document is related to the order, otherwise we don't
* @return : -1 if something is missing (generic log must detail default condition in proper session_name /context for RI display; 1 if all ius OK
*/


FUNCTION F_CHECK_ORDER_IS_DOCUSIGNABLE(ancopk IN NUMBER, anIgnoreWarnings IN NUMBER, ab_checkDoc BOOLEAN)
RETURN NUMBER
IS 
  ln_count_trs_Sg               NUMBER := 0;
  ln_count_trs_cont             NUMBER := 0;
  ln_count_doc                  NUMBER := 0;
  ls_co_reference               ABSIS.commitment.co_reference%TYPE;
  ln_co_brmo_fk                 ABSIS.commitment.co_brmo_fk%TYPE;
  ln_count_usage_third          NUMBER := 0;
  ln_count_usage_contact        NUMBER := 0;
  ln_brmo_dset_fk               ABSIS.broadcast_mode.brmo_dset_fk%TYPE;
  ln_count_templ_signer         NUMBER := 0;
  ln_count_sequence_user_email  NUMBER := 0;
  ls_dset_email_subject         ABSIS.ds_env_template.dset_email_subject%TYPE;
  ls_dset_email_blurb           VARCHAR2(4000);


BEGIN 
    -- check if email/first name/ last name  is completed, if not => error
    select count(*) into ln_count_sequence_user_email from commitment_approval, users where coa_co_fk = ancopk and coa_is_docusign = 1 and coa_stamp_usr_fk = usr_pk and (usr_email is null or usr_first_name is null or usr_last_name is null);
    if ln_count_sequence_user_email > 0 then 
      p_log(LEV_ERROR,'Au moins un des signataires désigné DOCUSIGN de la commande n''est pas entièrement qualifé par nom, prénom, email ','BODS_ERR_08', null);
      return -1;
    end if;
    -- check if broadcast_mode is related to a envelope template
    select brmo_dset_fk into ln_brmo_dset_fk from commitment, broadcast_mode, ds_env_template where co_pk = ancopk and co_brmo_fk = brmo_pk and brmo_dset_fk = dset_pk;
    if ln_brmo_dset_fk is null then 
      p_log(LEV_ERROR,'Le mode de diffusion est marqué DOCUSIGN mais n''est pas lié à un modèle d''envelope','BODS_ERR_09', null);
      return -1;
    end if;
    -- check if the envelop model contains a template signer from rank 0 without a fixed name and fixed email
      select count(*) into ln_count_templ_signer from ds_templ_signer, ds_env_template, commitment, broadcast_mode where dset_pk = brmo_dset_fk and dsts_dset_fk = dset_pk and dsts_match_rank = 0 and dsts_fixed_name is null and dsts_fixed_email is null and co_pk = ancopk and co_brmo_fk = brmo_pk and brmo_dset_fk = dset_pk;
      if ln_count_templ_signer <> 1 then 
        p_log(LEV_ERROR,'Le modèle d''envelope ne contient pas de modèle de signataire pour le fournisseur ( rank 0 )','BODS_ERR_10', null);
        return -1;
      end if;
    -- check if email subject is not null
    select nvl(dset_email_subject, netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ORDER_EMAIL_SUBJECT')) into ls_dset_email_subject from commitment, broadcast_mode, ds_env_template where co_pk = ancopk and co_brmo_fk = brmo_pk and brmo_dset_fk = dset_pk;
    
    if ls_dset_email_subject is null then 
      p_log(LEV_ERROR,'Le sujet pour l''email d''invitation DOCUSIGN n''est pas configuré ( modèle d''envelope ou paramètre global )','BODS_ERR_11', null);
      return -1;
    end if;
    -- check if email blurb is not null 
    select nvl(dset_email_blurb, netika_utility.fwk_param.getParam('8/DOCUSIGN/DOCUSIGN_ORDER_EMAIL_BLURB')) into ls_dset_email_blurb from commitment, broadcast_mode, ds_env_template where co_pk = ancopk and co_brmo_fk = brmo_pk and brmo_dset_fk = dset_pk;
    if ls_dset_email_blurb is null then 
      p_log(LEV_ERROR,'Le texte d''invitation à signer ( blurb ) n''est pas configuré ( modèle d''envelope ou paramètre global )','BODS_ERR_12', null);
      return -1;
    end if;
    -- check document(s)
    select co_brmo_fk, co_reference INTO ln_co_brmo_fk, ls_co_reference from commitment WHERe co_pk = ancopk;
    IF ab_checkDoc  THEN
        select count(*) into ln_count_doc from edm_reference, ds_templ_document, broadcast_mode where edmref_record_pk = ancopk and edmref_context = 'COMMITMENT' AND edmref_typeref_fk = dstd_typeref_fk AND dstd_dset_fk = brmo_dset_fk AND brmo_pk = ln_co_brmo_fk;
        IF ln_count_doc = 0 THEN 
          p_log(LEV_ERROR,'Aucun document de la commande pour les types de références renseignées dans les modèles de document du modèle d''envelope DOCUSIGN du mode de diffusion','BODS_ERR_04',null);
          RETURN -1;
        END IF;
    END IF;
    -- check supplier third and contacts
    FOR i in(     
    SELECT tiers_sieges.*
    FROM TIERS_SIEGES,
        COMMITMENT_PARTY,
        CO_PARTY_TYPE,
        usage_code, 
        usage_reference
    WHERE     CO_PART_COPARTT_FK = COPARTT_PK
        AND COPARTT_STEREOTYPE = 2
        AND CO_PART_CO_FK = ancopk
        AND CO_PART_TRS_SG_FK = TRS_SG_PK 
            AND UCR_RECORD_FK = TRS_SG_PK
            AND UCR_TABLE_CODE in ('TIERS_SIEGES')
            AND TRUNC (SYSDATE) BETWEEN UCR_START_DATE AND NVL (UCR_END_DATE, TRUNC (SYSDATE))
            AND UCR_UC_FK = UC_PK
            AND UC_CODE = netika_utility.fwk_param.getparam ('8/DOCUSIGN/DOCUSIGN_ORDER_RECIPIENT_USAGE'))
    LOOP
      ln_count_trs_Sg := ln_count_trs_Sg + 1;
      if i.trs_Sg_nom is null or i.trs_Sg_email is null or i.trs_sg_code is null then
          p_log(LEV_ERROR,'Le tiers-siège '||i.trs_sg_nom || ' n''a pas d''adresse mail renseignée','BODS_ERR_05','#1;'|| i.trs_sg_nom ||'#');
          RETURN -1;
      END IF;
    END LOOP;
    -- Check contacts 
    FOR i in(     
    SELECT trs_cont_pk, trs_cont_nom, trs_cont_email
    FROM TIERS_SIEGES,
         tiers_contacts,
        COMMITMENT_PARTY,
        CO_PARTY_TYPE,
        usage_code, 
        usage_reference
    WHERE     CO_PART_COPARTT_FK = COPARTT_PK
        AND COPARTT_STEREOTYPE = 2
        AND CO_PART_CO_FK = ancopk
        AND CO_PART_TRS_SG_FK = TRS_SG_PK
        and trs_cont_trs_Sg_fk = trs_Sg_pk 
            AND UCR_RECORD_FK = TRS_CONT_PK
            AND UCR_TABLE_CODE in ('TIERS_CONTACTS')
            AND TRUNC (SYSDATE) BETWEEN UCR_START_DATE AND NVL (UCR_END_DATE, TRUNC (SYSDATE))
            AND UCR_UC_FK = UC_PK
            AND UC_CODE =netika_utility.fwk_param.getparam ('8/DOCUSIGN/DOCUSIGN_ORDER_RECIPIENT_USAGE'))
    LOOP                
                ln_count_trs_cont := ln_count_trs_cont + 1;
                if i.trs_cont_nom is null or i.trs_cont_email is null then
                    p_log(LEV_ERROR,'Le contact '||i.trs_cont_nom || ' n''a pas d''adresse mail renseignée','BODS_ERR_06','#1;'|| i.trs_cont_nom ||'#');
                    RETURN -1;
                END IF;
    END LOOP;

    IF ln_count_trs_Sg +ln_count_trs_cont = 0 THEN
        p_log(LEV_ERROR,'Aucun siège ou contact renseigné avec l''usage destinataire de bon de commandes','BODS_ERR_07', null);
        RETURN -1;
    END IF; 
  RETURN 1;
  
END F_CHECK_ORDER_IS_DOCUSIGNABLE;		

FUNCTION F_AFTER_APPROVAL_DSN_FINISHED (an_dsen_pk IN NUMBER) RETURN NUMBER
/** Callback function called by webhook (by calling f_process_connect_event) when Docusign envelope is completed
* @param an_dsen_pk pk of the copleted envelope
* @return : 1 : success
* @return : 0 : warning : see generic_log - but cannot be shown to user as function is triggereb by webhook
* @return : < 0  : error : see generic_log
*/
IS
    ln_return               NUMBER;
    ln_target_wfs_pk        ABSIS.WORKFLOW_STEP.WFS_PK%TYPE;
    ln_co_wfs_pk            ABSIS.COMMITMENT.CO_WFS_FK%TYPE;
    ln_co_pk                ABSIS.DS_ENVELOPE.DSEN_RECORD_PK%TYPE;
    ln_wf_pk                ABSIS.WORKFLOW.WF_PK%TYPE;
    ln_classification       ABSIS.COMMITMENT_HEAD.COH_CLASSIFICATION%TYPE;
    ln_ct_reference_id      ABSIS.CONTEXT_TABLES.CT_REFERENCE_ID%TYPE;
    ln_system_Orgpos        number;

BEGIN
    
    BEGIN
        SELECT dsen_record_pk INTO ln_co_pk FROM DS_ENVELOPE WHERE dsen_pk = an_dsen_pk AND DSEN_CONTEXT = 'COMMITMENT';
    EXCEPTION 
    WHEN NO_DATA_FOUND THEN
        p_log(LEV_ERROR,'No record pk of type COMMITMENT found in envelope dsen_pk = '||to_char(an_dsen_pk),'BODS_ERR_02','#1;'||to_char(an_dsen_pk)||'#');
        return -1;
    END;    

    SELECT  co_wfs_fk,
            wfs_wf_fk,
            coh_classification,
            ct_reference_id
    INTO    ln_co_wfs_pk,
            ln_wf_pk,
            ln_classification,
            ln_ct_reference_id
    FROM    ABSIS.COMMITMENT,
            ABSIS.COMMITMENT_HEAD,
            ABSIS.BROADCAST_MODE,
            ABSIS.WORKFLOW_STEP,
            ABSIS.WORKFLOW,
            CONTEXT_TABLES
     WHERE   co_pk = ln_co_pk      AND
             co_coh_fk = coh_pk    AND
             co_brmo_fk = brmo_pk  and
             co_wfs_fk = wfs_pk
             and wfs_wf_fk = wf_pk
             and wf_ct_fk = ct_pk;

     IF ln_classification = 4 THEN -- purchase order , only managed case by now
        SELECT wfs_pk
        INTO  ln_target_wfs_pk
        FROM  ABSIS.WORKFLOW_STEP,
              ABSIS.WORKFLOW
        WHERE wfs_code = '30_VALIDATED'        AND
              wfs_wf_fk = wf_pk                AND
              wf_pk = ln_wf_pk;
     END IF;
     
     
     ln_system_orgpos := netika_utility.fwk_param.getParam('0/LOGIN/SYSTEM_ORGPOS');
     
     -- créer des références entre documents signés et commande
     
     insert into edm_reference (EDMREF_PK, EDMREF_EDMDOC_FK, EDMREF_CONTEXT, EDMREF_RECORD_PK, EDMREF_ORIGIN, EDMREF_TYPEREF_FK) select
     sq_edmref_pk.nextval,
     dsdo_signed_edmdoc_fk, 
     'COMMITMENT',
     ln_co_pk,
     10,
     edmtr_pk
     from ds_document,edm_type_reference where dsdo_dsen_fk = an_dsen_pk 
     and edmtr_code = 'PO_SIGNED_DOC';
     
     
     ln_return := bo_workflow.ChangeStep(ln_co_pk, ln_ct_reference_id, ln_system_orgpos,ln_co_wfs_pk, ln_target_wfs_pk, ' ',1 );
     
     IF ln_return < 0 THEN
          RETURN ln_return;
     END IF;
     RETURN 1;
     
END F_AFTER_APPROVAL_DSN_FINISHED;	

FUNCTION F_DOCUSIGN_REJECTED(an_dsen_pk NUMBER) RETURN NUMBER 
IS 
  ln_return             NUMBER;
  ln_dses_status        ABSIS.ds_env_signer.dses_status%TYPE;
  ln_co_pk              ABSIS.DS_ENVELOPE.DSEN_RECORD_PK%TYPE;
  ln_target_wfs_pk      ABSIS.WORKFLOW_STEP.WFS_PK%TYPE;
  ln_co_wfs_pk          ABSIS.COMMITMENT.CO_WFS_FK%TYPE;
  ln_wf_pk              ABSIS.WORKFLOW.WF_PK%TYPE;
  ln_classification     ABSIS.COMMITMENT_HEAD.COH_CLASSIFICATION%TYPE;
  ln_ct_reference_id    ABSIS.CONTEXT_TABLES.CT_REFERENCE_ID%TYPE;
  ln_system_orgpos      NUMBER;
BEGIN
    SELECT dsen_record_pk INTO ln_co_pk FROM DS_ENVELOPE WHERE dsen_pk = an_dsen_pk AND DSEN_CONTEXT = 'COMMITMENT';

    SELECT  co_wfs_fk,
            wfs_wf_fk,
            coh_classification,
            ct_reference_id
    INTO    ln_co_wfs_pk,
            ln_wf_pk,
            ln_classification,
            ln_ct_reference_id
            FROM    ABSIS.COMMITMENT,
                    ABSIS.COMMITMENT_HEAD,
                    ABSIS.BROADCAST_MODE,
                    ABSIS.WORKFLOW_STEP,
                    ABSIS.WORKFLOW,
                    CONTEXT_TABLES
                    WHERE   co_pk = ln_co_pk      and
                            co_coh_fk = coh_pk    and
                            co_brmo_fk = brmo_pk  and
                            co_wfs_fk = wfs_pk    and
                            wfs_wf_fk = wf_pk     and
                            wf_ct_fk = ct_pk;
    SELECT wfs_pk
    INTO  ln_target_wfs_pk
    FROM  ABSIS.WORKFLOW_STEP,
          ABSIS.WORKFLOW
    WHERE wfs_code = '24_DOCUSIGN_REJECTED'        AND
          wfs_wf_fk = wf_pk                        AND
          wf_pk = ln_wf_pk;

  ln_system_orgpos := netika_utility.fwk_param.getParam('0/LOGIN/SYSTEM_ORGPOS');
  
  ln_return := bo_workflow.ChangeStep(ln_co_pk, ln_ct_reference_id, ln_system_orgpos,ln_co_wfs_pk, ln_target_wfs_pk, ' ',1 );
  if ln_return < 0 then 
    return ln_return;
  end if;
  UPDATE commitment SET CO_AMENDMENT_STATUS = 6 where co_pk = ln_co_pk; 
  return 1;
END F_DOCUSIGN_REJECTED;

FUNCTION F_DOCUSIGN_VOIDED(an_dsen_pk NUMBER) RETURN NUMBER 
IS 
  ln_return             NUMBER;
  ln_dses_status        ABSIS.ds_env_signer.dses_status%TYPE;
  ln_co_pk              ABSIS.DS_ENVELOPE.DSEN_RECORD_PK%TYPE;
  ln_target_wfs_pk      ABSIS.WORKFLOW_STEP.WFS_PK%TYPE;
  ln_co_wfs_pk          ABSIS.COMMITMENT.CO_WFS_FK%TYPE;
  ln_wf_pk              ABSIS.WORKFLOW.WF_PK%TYPE;
  ln_classification     ABSIS.COMMITMENT_HEAD.COH_CLASSIFICATION%TYPE;
  ln_ct_reference_id    ABSIS.CONTEXT_TABLES.CT_REFERENCE_ID%TYPE;
  ln_system_orgpos      NUMBER;
BEGIN 
    SELECT dsen_record_pk INTO ln_co_pk FROM DS_ENVELOPE WHERE dsen_pk = an_dsen_pk AND DSEN_CONTEXT = 'COMMITMENT';

  SELECT  co_wfs_fk,
          wfs_wf_fk,
          coh_classification,
          ct_reference_id
  INTO    ln_co_wfs_pk,
          ln_wf_pk,
          ln_classification,
          ln_ct_reference_id
          FROM    ABSIS.COMMITMENT,
                  ABSIS.COMMITMENT_HEAD,
                  ABSIS.BROADCAST_MODE,
                  ABSIS.WORKFLOW_STEP,
                  ABSIS.WORKFLOW,
                  CONTEXT_TABLES
                  WHERE   co_pk = ln_co_pk      and
                          co_coh_fk = coh_pk    and
                          co_brmo_fk = brmo_pk  and
                          co_wfs_fk = wfs_pk    and
                          wfs_wf_fk = wf_pk     and
                          wf_ct_fk = ct_pk;
  SELECT wfs_pk
  INTO  ln_target_wfs_pk
  FROM  ABSIS.WORKFLOW_STEP,
        ABSIS.WORKFLOW
  WHERE wfs_code = '24_DOCUSIGN_REJECTED'        AND
        wfs_wf_fk = wf_pk                        AND
        wf_pk = ln_wf_pk;

ln_system_orgpos := netika_utility.fwk_param.getParam('0/LOGIN/SYSTEM_ORGPOS');

ln_return := bo_workflow.ChangeStep(ln_co_pk, ln_ct_reference_id, ln_system_orgpos,ln_co_wfs_pk, ln_target_wfs_pk, ' ',1 );
if ln_return < 0 then 
  return ln_return;
end if;
UPDATE commitment SET CO_AMENDMENT_STATUS = 7 where co_pk = ln_co_pk; 
return 1;
END F_DOCUSIGN_VOIDED;

FUNCTION F_DOCUSIGN_REFUSED_TO_VALID(an_record_Pk NUMBER, an_user_Pk NUMBER, an_wfs_Pk NUMBER, anIgnoreWarning IN NUMBER) RETURN NUMBER 
IS 
BEGIN
  UPDATE commitment SET CO_AMENDMENT_STATUS = 2 where co_pk = an_record_Pk; 
  RETURN 1;
END F_DOCUSIGN_REFUSED_TO_VALID;


FUNCTION F_HIDE_DOCUSIGN_TAB RETURN NUMBER 
IS 
ln_brmo_code ABSIS.broadcast_mode.brmo_code%TYPE;
BEGIN 

  select brmo_code into ln_brmo_code from broadcast_mode, commitment, commitment_head where co_pk = bo_env.getRecordPk and co_brmo_fk = brmo_pk and co_coh_fk = coh_pk;

  if ln_brmo_code = 'CO_DOCUSIGN' THEN 
    return 1;
  else 
    return 0;
  end if;

END F_HIDE_DOCUSIGN_TAB;


END BO_DOCUSIGN;
/

grant execute on absis.bo_docusign to netika_custom with grant option;