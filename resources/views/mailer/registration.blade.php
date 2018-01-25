<p>Hi, {{ $user->first_name}} {{ $user->last_name}}</p>
<p>Thanks for registering in GyanMitra18</p>
{{ link_to_route('auth.activate', 'Click Here', ['email' => $user->email, 'activation_code' => $user->activation_code]) }} to confirm your account




<p>******************************************DONT REPLY TO THIS MAIL ITS AUTO GENERATED******************************************</p>
<p>TO CONTACT US :gyanmitra18@mepcoeng.ac.in</p>