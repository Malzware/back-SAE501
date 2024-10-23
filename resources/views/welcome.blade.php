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
       .signature-pad {
            border: 1px solid #ccc;
            margin: 10px 0;
        }
        canvas {
            width: 400px;
            height: 200px;
        }
  </style>

<body>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div>
        <a href="/pdf">Download user list</a><br/>
        <img src="https://preview.ibb.co/jnW4Qz/Grumpy_Cat_920x584.jpg" width=400 height=200 />
    </div>

    <?php
    if (extension_loaded('gd')) {
        echo "GD is installed!";
    } else {
        echo "GD is NOT installed!";
    }
    ?>

    <!-- <div>
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
</div> -->

       <div>
       <form method="POST" action="{{ route('send.signature') }}">
    @csrf
    <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
    <div>
        <label>Signature</label>
        <div class="signature-pad">
            <canvas></canvas>
            <!-- Add this hidden input -->
            <input type="hidden" name="signature" id="signature">
        </div>
        <div id="signature-pad_footer">
            <button type="button" id="clear-signature" class="btn btn-danger">Clear</button>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-2">
        {{__('Submit') }}
    </button>
            </form>
       </div>

       <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
       <script>
        //Init signature_pad
    var canvas = document.querySelector("canvas");
    var ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);

    var signaturePad = new SignaturePad(canvas);

        //clear sign
        document.getElementById('clear-signature').addEventListener('click', function(e) {
        signaturePad.clear();
    });

        //submission
        document.querySelector('form[action="{{ route("send.signature") }}"]').addEventListener('submit', function(e) {
        var signatureInput = document.getElementById('signature');
        if (signaturePad.isEmpty()) {
            e.preventDefault();
            alert('Please draw your signature.');
        } else {
            signatureInput.value = signaturePad.toDataURL();
        }
    });
</script>
</html>