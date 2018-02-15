<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GyanMitra18 Attendance</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .header{
            padding: 5px;
            text-align: center;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;                
        }
        body{
            border: 1px solid #000;

           
        }
        img{
            width:100%;
            height:100%;
        }
        
    </style>    
    </head>
    <body>
        <img src="image/header.jpg" class="img-responsive" alt="Header Image">
        <table class="table table-striped">
        <thead>
        <tr>
            <th>GMID</th>
            <th>NAME</th>
            <th>College</th>
            <th>Contact</th>
            <th>Signature</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->GMId()}}</td>
            <td>{{$user->first_name}} {{$user->last_name}}</td>
            <td>{{ $user->college->getQualifiedName() }}</td>
            <td>{{$user->mobile}}</td>
            <td> </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
