@extends('layouts.app')

@section('title', 'Share Voting Slip')

@section('extra-styles')
<style>
.share-page { max-width: 600px; margin: 2rem auto; padding: 0 1rem; }
.share-card { background: var(--white); border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); overflow: hidden; }
.share-card-header {
    background: linear-gradient(135deg, var(--red-700), var(--red-500));
    padding: 1.4rem; text-align: center; color: var(--white);
}
.share-card-header h2 { font-size: 1.15rem; font-weight: 800; margin-bottom: 0.2rem; }
.share-card-header p { font-size: 0.8rem; opacity: 0.8; }
.share-card-body { padding: 1.75rem; }

/* Slip preview */
.slip-preview { border: 2.5px solid var(--red-500); border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 1.5rem; }
.slip-p-header { background: var(--gray-900); padding: 9px 14px; text-align: center; }
.slip-p-title { color: var(--white); font-size: 0.78rem; font-weight: 800; }
.slip-p-subtitle { color: rgba(255,255,255,0.55); font-size: 0.66rem; margin-top: 2px; }
.slip-p-body { padding: 0.9rem 1.1rem; display: flex; gap: 0.9rem; align-items: center; }
.slip-p-num {
    background: var(--red-600); color: var(--white);
    font-weight: 900;
    min-width: 54px; height: 54px; padding: 0 6px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; white-space: nowrap;
}
.slip-p-info { flex: 1; }
.slip-p-srlabel { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gray-400); }
.slip-p-name { font-size: 1rem; font-weight: 800; color: var(--red-600); margin-bottom: 0.25rem; }
.slip-p-detail { font-size: 0.72rem; color: var(--gray-500); }
.slip-p-numbers {
    background: linear-gradient(135deg, var(--red-500), var(--salmon));
    padding: 6px 12px; display: flex; gap: 4px; align-items: center; flex-wrap: wrap;
}
.slip-p-num-chip {
    background: var(--white); color: var(--red-600);
    font-size: 0.63rem; font-weight: 900;
    width: 22px; height: 22px; border-radius: 3px;
    display: flex; align-items: center; justify-content: center;
}
.slip-p-footer {
    background: var(--gray-900); padding: 6px 12px;
    font-size: 0.66rem; font-weight: 600; color: rgba(255,255,255,0.65);
    display: flex; justify-content: space-between; align-items: center;
}
.slip-p-verified { color: #86efac; font-weight: 700; }

/* Share action buttons */
.share-actions { display: flex; flex-direction: column; gap: 0.75rem; }
.share-actions-title { font-size: 0.78rem; font-weight: 700; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.06em; }
.share-buttons { display: flex; gap: 0.65rem; flex-wrap: wrap; }
.btn-whatsapp {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.72rem 1.1rem; background: #25D366; color: var(--white);
    border-radius: var(--radius-md); font-size: 0.86rem; font-weight: 700;
    text-decoration: none; transition: filter 0.15s;
}
.btn-whatsapp:hover { filter: brightness(1.08); }
.btn-download-share {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.72rem 1.1rem;
    background: linear-gradient(135deg, var(--red-700), var(--red-500));
    color: var(--white); border-radius: var(--radius-md);
    font-size: 0.86rem; font-weight: 700;
    text-decoration: none; transition: filter 0.15s;
}
.btn-download-share:hover { filter: brightness(1.08); }
.btn-copy {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.72rem 1.1rem; background: var(--gray-100); color: var(--gray-700);
    border: 2px solid var(--gray-200); border-radius: var(--radius-md);
    font-size: 0.86rem; font-weight: 700; cursor: pointer;
    font-family: inherit; transition: background 0.15s;
}
.btn-copy:hover { background: var(--gray-200); }
.back-link {
    display: inline-flex; align-items: center; gap: 0.35rem;
    color: var(--red-600); font-size: 0.8rem; font-weight: 600;
    text-decoration: none; margin-top: 1rem;
}
.back-link:hover { text-decoration: underline; }
</style>
@endsection

@section('content')
<div class="main-content">
    <div class="share-page">
        <div class="share-card">
            <div class="share-card-header">
                <h2>Your Voting Slip</h2>
                <p>Download or share your confirmed voting slip</p>
            </div>
            <div class="share-card-body">

                {{-- Slip preview --}}
                <div class="slip-preview">
                    <div style="border-bottom:2px solid var(--red-500)">
                        <img src="/images/candidate-badge.png" alt="Dr. Sanjaykumar S. Deshmukh — MMC Elections 2026" style="width:100%;display:block;">
                    </div>
                    <div class="slip-p-body">
                        @if($voter->electoral_number)
                        @php
                            $elen = strlen($voter->electoral_number);
                            $efont = $elen <= 2 ? '1.9rem' : ($elen <= 3 ? '1.6rem' : ($elen <= 4 ? '1.25rem' : ($elen <= 5 ? '1rem' : ($elen <= 7 ? '0.8rem' : '0.65rem'))));
                        @endphp
                        <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex-shrink:0">
                            <div style="font-size:0.55rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--gray-400)">Electoral No.</div>
                            <div class="slip-p-num" style="font-size:{{ $efont }};line-height:1;display:flex;align-items:center;justify-content:center;">{{ $voter->electoral_number }}</div>
                        </div>
                        @endif
                        <div class="slip-p-info">
                            <div class="slip-p-srlabel">Voter Name</div>
                            <div class="slip-p-name">{{ $voter->name }}</div>
                            <div class="slip-p-detail">
                                @if($voter->registration_number) Reg: {{ $voter->registration_number }} &nbsp; @endif
                                @if($voter->branch) {{ $voter->branch }} @endif
                                &nbsp;|&nbsp; Dr. Sanjaykumar S. Deshmukh
                            </div>
                        </div>
                    </div>
                    <div class="slip-p-numbers">
                        @foreach([1, 13, 24, 27, 29, 40, 43, 48, 56] as $n)
                            <div class="slip-p-num-chip">{{ $n }}</div>
                        @endforeach
                        <span style="margin-left:auto;color:rgba(255,255,255,0.85);font-size:0.65rem;font-weight:700;">IMA Official Panel</span>
                    </div>
                    <div class="slip-p-footer">
                        <span>Sunday, 26th April 2026 &nbsp;|&nbsp; 8AM – 5PM &nbsp;|&nbsp; {{ $venue }}</span>
                        <span class="slip-p-verified">✓ Verified</span>
                    </div>
                </div>

                {{-- Share actions --}}
                <div class="share-actions">
                    <div class="share-actions-title">Share or Download</div>
                    <div class="share-buttons">
                        <a
                            href="https://wa.me/?text={{ urlencode('I found my name in the voter list! 🗳️ ' . $voter->name . ' — MMC Elections 2026. Vote for IMA Official Panel: 1, 13, 24, 27, 29, 40, 43, 48, 56. SR. No. 13: Dr. Sanjaykumar S. Deshmukh, Radiologist, Pandharpur. My slip: ' . route('slip.share', $voter->id)) }}"
                            target="_blank"
                            class="btn-whatsapp"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Share on WhatsApp
                        </a>
                        <a href="{{ route('slip.download', $voter->id) }}" class="btn-download-share">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download PDF
                        </a>
                        <button type="button" class="btn-copy" onclick="copyLink(this)" data-url="{{ route('slip.share', $voter->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Copy Link
                        </button>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="back-link">← Back to Search</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-scripts')
<script>
function copyLink(btn) {
    navigator.clipboard.writeText(btn.dataset.url).then(() => {
        btn.textContent = '✓ Copied!';
        setTimeout(() => { btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg> Copy Link`; }, 2000);
    });
}
</script>
@endsection
