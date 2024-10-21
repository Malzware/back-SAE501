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
    <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
    </form>
</div>
  
<script type="text/javascript">
</script>
</body>
</html>