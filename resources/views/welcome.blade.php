<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

  <style>
       body {
        background-color: gray;
       }
  </style>

<body>
    <div>
        <a href="/pdf">Download user list</a><br/>
        <img src="https://preview.ibb.co/jnW4Qz/Grumpy_Cat_920x584.jpg" width=400 height=200 />
    </div>
    
    <div>
    <form action="/pdf" method="POST">
    @csrf
        <label for="name">FirstName:</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="name">LastName:</label>
        <input type="text" id="lastname" name="lastname" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <button type="submit">Download PDF</button>
    </form>
</div>
  
<script type="text/javascript">
</script>
</body>
</html>