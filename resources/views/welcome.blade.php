<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Preview URL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
        }

        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .preview-url {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            word-break: break-all;
        }
    </style>
</head>

<!-- @if(session('success'))
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
            Add this hidden input
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
</html> -->

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

    <h2>Generate Preview URL</h2>
    
    <form method="POST" action="{{ route('generate.preview.url') }}">
        @csrf
        <div class="form-group">
            <label for="email">User Email:</label>
            <input type="email" id="email" name="email" required>
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn">Generate URL</button>
    </form>

    @if(isset($previewUrl))
        <div class="preview-url">
            <strong>Preview URL:</strong>
            <p>{{ $previewUrl }}</p>
            <button onclick="copyToClipboard('{{ $previewUrl }}')" class="btn">Copy URL</button>
        </div>
    @endif

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('URL copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</body>
</html>