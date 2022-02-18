@component('mail::message')
Hello {{ $user->firstname }}

<div style="text-align: center !important">
    <h1 style="font-size: 50px; color:rgb(170, 0, 0); ">Welkome</h1>
    <p class="text-center">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae nihil, eligendi ad numquam aperiam consequatur atque quaerat reiciendis consectetur, tenetur modi, quisquam doloribus itaque iure?</p>
</div>
@component('mail::button', ['url' => 'https://www.innovafurniture.be/login'])
Lets' go
@endcomponent

Thanks,<br>
<a target="_blank" href="https://www.innovafurniture.be/">Innova Furniture</a>
@endcomponent
