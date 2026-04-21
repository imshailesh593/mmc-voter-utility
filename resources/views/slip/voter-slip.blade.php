<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting Slip — {{ $voter->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; background: #fff; color: #1e293b; }

        .slip { width: 100%; border: 3px solid #dc2626; border-radius: 6px; overflow: hidden; }

        /* ── Clipped hero ── */
        .hero-clip { height: 168pt; overflow: hidden; border-bottom: 2px solid #dc2626; }
        .hero-clip img { width: 100%; }

        /* ── Voter body ── */
        .body { padding: 9pt 13pt 8pt; background: #fff; border-bottom: 1px solid #f1f5f9; }
        .body-table { width: 100%; border-collapse: collapse; }
        .body-table td { vertical-align: middle; padding: 0; }

        .num-td { width: 64pt; text-align: center; }
        .num-label { font-size: 6.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 3pt; }
        .num-box {
            background: #dc2626; color: #fff;
            font-size: 26pt; font-weight: bold;
            width: 52pt; height: 52pt; line-height: 40pt;
            border-radius: 8pt; border: 2pt solid #991b1b;
            text-align: center; display: block; margin: 0 auto;
            padding-bottom: 12pt;
        }

        .sep-td { width: 1pt; padding: 0 10pt; }
        .sep-line { width: 1pt; height: 56pt; background: #e2e8f0; display: block; }

        .info-td { padding-left: 4pt; }
        .v-label { font-size: 6.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 3pt; }
        .v-name  { font-size: 17pt; font-weight: bold; color: #dc2626; line-height: 1.15; margin-bottom: 6pt; }

        .details { width: 100%; border-collapse: collapse; }
        .details td { padding: 0 14pt 0 0; vertical-align: top; }
        .d-label { font-size: 6pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8; margin-bottom: 1pt; }
        .d-value { font-size: 9pt; font-weight: bold; color: #1e293b; }

        /* ── Numbers strip ── */
        .strip { background: #ef4444; padding: 7pt 13pt; }
        .strip-table { width: 100%; border-collapse: collapse; }
        .strip-table td { vertical-align: middle; padding: 0; }
        .strip-label { color: #fff; font-size: 11pt; font-weight: bold; text-align: left; padding-right: 10pt; white-space: nowrap; }
        .chip-td { padding-left: 5pt; }
        .chip {
            background: #fff; color: #dc2626;
            font-size: 9pt; font-weight: bold;
            width: 28pt; height: 26pt; line-height: 22pt;
            border-radius: 4pt; text-align: center; display: block;
            padding: 0 3pt; padding-bottom: 4pt;
        }

        /* ── Footer ── */
        .footer { background: #1e293b; padding: 6pt 13pt; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-table td { vertical-align: middle; padding: 0; }
        .f-date { font-size: 7.5pt; font-weight: bold; color: rgba(255,255,255,0.75); }
        .f-key { font-size: 6pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.4); display: block; margin-bottom: 1pt; }
        .f-val { font-size: 8pt; font-weight: bold; color: rgba(255,255,255,0.85); display: block; }
        .f-stamp {
            font-size: 7pt; color: #86efac;
            border: 1.5pt solid #86efac; border-radius: 3pt;
            padding: 2pt 6pt; font-weight: bold;
            text-transform: uppercase; letter-spacing: 0.06em;
            display: block; text-align: center;
        }
    </style>
</head>
<body>
<div class="slip">

    {{-- Hero image clipped to top 168pt --}}
    <div class="hero-clip">
        <img src="file://{{ public_path('images/candidate-badge.png') }}" alt="Dr. Sanjaykumar S. Deshmukh">
    </div>

    {{-- Voter details --}}
    <div class="body">
        <table class="body-table">
            <tr>
                <td class="num-td">
                    <div class="num-label">Vote For</div>
                    <div class="num-box">13</div>
                </td>
                <td class="sep-td">
                    <span class="sep-line"></span>
                </td>
                <td class="info-td">
                    <div class="v-label">Voter Name</div>
                    <div class="v-name">{{ $voter->name }}</div>
                    <table class="details">
                        <tr>
                            @if($voter->branch)
                                <td>
                                    <div class="d-label">Branch</div>
                                    <div class="d-value">{{ $voter->branch }}</div>
                                </td>
                            @endif
                            @if($voter->registration_number)
                                <td>
                                    <div class="d-label">Reg. No.</div>
                                    <div class="d-value">{{ $voter->registration_number }}</div>
                                </td>
                            @endif
                            <td>
                                <div class="d-label">Candidate</div>
                                <div class="d-value">Dr. Sanjaykumar S. Deshmukh</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    {{-- Panel numbers --}}
    <div class="strip">
        <table class="strip-table">
            <tr>
                <td class="strip-label">IMA Official Panel — MMC'26</td>
                @foreach([1, 13, 24, 27, 29, 40, 43, 48, 56] as $n)
                    <td class="chip-td"><div class="chip">{{ $n }}</div></td>
                @endforeach
            </tr>
        </table>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td class="f-date">
                    <span class="f-key">Voting Date</span>
                    <span class="f-val">Sunday, 26th April 2026 &nbsp;&nbsp;|&nbsp;&nbsp; 8AM – 5PM</span>
                </td>
                <td style="width:10pt"></td>
                <td class="f-date">
                    <span class="f-key">Venue</span>
                    <span class="f-val">District Headquarter</span>
                </td>
                <td style="width:80pt; text-align:right">
                    <span class="f-stamp">✓ Verified</span>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>
