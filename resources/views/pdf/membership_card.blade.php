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

        .card {
            width: 600px;
            border: 3px solid #000;
            padding: 20px;
            box-sizing: border-box;
            position: relative;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #800000;
            padding-bottom: 10px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .title {
            flex-grow: 1;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #800000;
            user-select: none;
        }

        .kenyan-flag {
            height: 8px;
            display: flex;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .kenyan-flag div {
            flex: 1;
        }

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
            font-size: 14px;
        }

        .info p {
            margin: 6px 0;
        }

        .photo img {
            width: 130px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #000;
        }

        .footer {
            margin-top: 5px;
            font-size: 10px;
            text-align: center;
            color: #333;
            border-top: 1px dashed #999;
            padding-top: 5px;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Header -->
        <div class="header">
            <!-- Logo -->
            @if(file_exists($logo))
                <img src="{{ $logo }}" class="logo" alt="KESA Logo"> <l style="flex-grow: 1; text-align: left; font-size: 20px; font-weight: bold; color: #800000;">
        KESA MEMBERSHIP CARD
            </l>
                    @else
                        <div class="logo">Logo Missing</div><l style="flex-grow: 1; text-align: left; font-size: 20px; font-weight: bold; color: #800000;">
                KESA MEMBERSHIP CARD
            </l>
                    @endif
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

                    @if(file_exists($qrCode))
                        <div style="margin-top: 10px;">
                            <img src="{{ $qrCode }}" alt="QR Code" style="width: 100px; height: 100px;">
                        </div>
                    @else
                        <p style="font-size:12px; color: gray;">QR Code Missing</p>
                    @endif
                </td>

                <td class="photo" style="width: 130px; text-align: center;">
                    @if(file_exists($photo))
                        <img src="{{ $photo }}" alt="Profile Photo">
                    @else
                        <p style="font-size:12px;">Photo Missing</p>
                    @endif
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
