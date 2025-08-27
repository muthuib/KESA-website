<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>KESA Membership Card</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #fff; 
            margin: 0; 
            padding: 0; 
        }

        /* Kenyan ID size ~ 1011 x 637 px @300dpi */
        .card { 
            width: 1011px; 
            height: 637px; 
            border: 3px solid #000; 
            padding: 28px; 
            box-sizing: border-box; 
            position: relative; 
        }

        .header { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            border-bottom: 3px solid #800000; 
            padding-bottom: 12px; 
        }

        .logo { 
            width: 110px; 
            height: auto; 
        }

        .title { 
            flex-grow: 1; 
            text-align: center; 
            font-size: 32px; 
            font-weight: bold; 
            color: #800000; 
            user-select: none; 
        }

        .kenyan-flag { 
            height: 10px; 
            display: flex; 
            margin-top: 6px; 
            margin-bottom: 12px; 
        }

        .kenyan-flag div { flex: 1; }
        .flag-black { background-color: black; }
        .flag-white { background-color: white; }
        .flag-red { background-color: red; }
        .flag-green { background-color: green; }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 0; 
        }

        td { 
            vertical-align: top; 
            font-size: 20px; 
        }

        .info p { 
            margin: 8px 0; 
        }

        .photo img { 
            width: 200px; 
            height: 240px; 
            object-fit: cover; 
            border: 2px solid #000; 
        }

        .footer { 
            margin-top: 8px; 
            font-size: 12px; 
            text-align: center; 
            color: #333; 
            border-top: 1px dashed #999; 
            padding-top: 8px; 
            user-select: none; 
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Header -->
        <div class="header">
            <img src="{{ $logo }}" class="logo" alt="KESA Logo">
            <div class="title">KESA MEMBERSHIP CARD</div>
        </div>

        <!-- Kenyan Flag -->
        <div class="kenyan-flag">
            <div class="flag-black"></div>
            <div class="flag-white"></div>
            <div class="flag-red"></div>
            <div class="flag-white"></div>
            <div class="flag-green"></div>
        </div>

        <!-- Info + Photo -->
        <table>
            <tr>
                <td class="info">
                    <p><strong>Name:</strong> {{ $name }}</p>
                    <p><strong>Institution:</strong> {{ $SCHOOL_NAME ?? 'N/A' }}</p>
                    <p><strong>Date of Issuance:</strong> {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
                    <p><strong>Membership No:</strong> {{ $membershipNumber }}</p>

                    <div style="margin-top:12px;">
                        <img src="{{ $qrCode }}" alt="QR Code" style="width: 130px; height: 130px;">
                    </div>
                </td>

                <td class="photo" style="width: 200px; text-align: center;">
                    <img src="{{ $photo }}" alt="Profile Photo">
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} Economics Students Association of Kenya | All rights reserved.
        </div>
    </div>
</body>
</html>
