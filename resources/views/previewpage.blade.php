<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Preview & Signature</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pdf-preview {
            flex: 1;
            border: 1px solid #ccc;
            padding: 10px;
            height: 600px;
        }

        .signature-section {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 400px;
            margin: 0 auto;
        }

        .signature-pad {
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 10px 0;
        }

        canvas {
            width: 100%;
            height: 200px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="pdf-preview">
            <iframe src="{{ route('preview.pdf', ['payload' => $payload]) }}" title="PDF Preview"></iframe>
        </div>

        <div class="signature-section">
            <form id="signatureForm" method="POST" action="{{ route('submit.signature') }}">
                @csrf
                <input type="hidden" name="payload" value="{{ $payload }}">
                <div>
                    <label>Your Signature</label>
                    <div class="signature-pad">
                        <canvas></canvas>
                        <input type="hidden" name="signature" id="signature">
                    </div>
                    <div>
                        <button type="button" id="clear-signature" class="btn btn-danger">Clear</button>
                        <button type="submit" class="btn btn-primary">Sign & Download PDF</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var canvas = document.querySelector("canvas");
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        
        var signaturePad = new SignaturePad(canvas);

        document.getElementById('clear-signature').addEventListener('click', function() {
            signaturePad.clear();
        });

        document.getElementById('signatureForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (signaturePad.isEmpty()) {
                alert('Please provide a signature');
                return false;
            }
            
            document.getElementById('signature').value = signaturePad.toDataURL();
            this.submit();
        });
    </script>
</body>
</html>