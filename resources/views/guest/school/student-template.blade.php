<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Muat Naik Pelajar - Platform E-Tuisyen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/student-friendly.css') }}" rel="stylesheet">
    <style>
        .sf-template-table {
            background: white;
            border-radius: var(--sf-radius-xl);
            box-shadow: var(--sf-shadow-md);
            overflow: hidden;
            margin: 2rem 0;
        }

        .sf-template-table table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .sf-template-table th {
            background: linear-gradient(135deg, var(--sf-mint-fresh), var(--sf-mint-deep));
            color: white;
            font-weight: 700;
            padding: 1rem 0.75rem;
            text-align: left;
            border: none;
        }

        .sf-template-table td {
            border: 1px solid var(--sf-sky-light);
            padding: 0.875rem 0.75rem;
        }

        .sf-template-table tbody tr:nth-child(odd) {
            background: var(--sf-cream-soft);
        }

        .sf-template-table tbody tr:hover {
            background: rgba(91, 164, 230, 0.08);
        }

        .sf-sample-row {
            background: rgba(255, 209, 102, 0.15) !important;
            color: var(--sf-text-soft);
            font-style: italic;
        }

        .sf-download-box {
            background: linear-gradient(135deg, var(--sf-mint-fresh), var(--sf-mint-deep));
            color: white;
            padding: 2rem;
            border-radius: var(--sf-radius-xl);
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(107, 203, 158, 0.3);
        }

        .sf-download-box h3 {
            font-weight: 800;
            margin-bottom: 0.75rem;
        }

        .sf-download-box p {
            opacity: 0.95;
            margin-bottom: 1.25rem;
        }

        .sf-download-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .sf-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--sf-radius-full);
            color: white;
            font-weight: 700;
            text-decoration: none;
            transition: var(--sf-transition-normal);
        }

        .sf-download-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }

        .sf-instructions-box {
            background: var(--sf-sky-light);
            border: 2px solid var(--sf-sky-medium);
            border-radius: var(--sf-radius-xl);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .sf-instructions-box h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--sf-text-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sf-instructions-box ol, .sf-instructions-box ul {
            color: var(--sf-text-warm);
            margin-left: 1.25rem;
            line-height: 1.8;
        }

        .sf-instructions-box li {
            margin-bottom: 0.35rem;
        }

        .sf-required-tag {
            color: var(--sf-coral-bright);
            font-weight: 800;
        }

        .sf-optional-tag {
            color: var(--sf-text-muted);
            font-size: 0.85rem;
        }

        .sf-field-desc-box {
            background: white;
            border: 2px solid var(--sf-sky-light);
            border-left: 4px solid var(--sf-ocean-bright);
            border-radius: var(--sf-radius-lg);
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .sf-field-desc-box h3 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--sf-text-dark);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sf-field-desc-box ul {
            color: var(--sf-text-warm);
            line-height: 1.8;
        }

        .sf-field-desc-box li strong {
            color: var(--sf-text-dark);
        }

        @media (max-width: 768px) {
            .sf-template-table {
                overflow-x: auto;
            }

            .sf-download-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body class="sf-body">
    <!-- Background Pattern -->
    <div class="sf-bg-pattern"></div>
    
    <!-- Floating Shapes -->
    <div class="sf-floating-shapes">
        <div class="sf-shape sf-shape-1"></div>
        <div class="sf-shape sf-shape-2"></div>
        <div class="sf-shape sf-shape-3"></div>
    </div>

    <div class="container" style="position: relative; z-index: 1; padding: 2rem 1rem 3rem;">
        <!-- Logo Row -->
        <div class="sf-logo-row sf-fade-in" style="display: flex; align-items: center; justify-content: center; gap: 1.25rem; margin: 0 auto 2rem; animation: sf-bounce-vertical 3s ease-in-out infinite;">
            <img src="{{ asset('assets/images/logo/pkibs.png') }}" alt="PIBKS Logo" style="height: 55px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));">
            <img src="{{ asset('assets/images/logo/Kolej-UNITI.png') }}" alt="UNITI Logo" style="height: 55px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));">
        </div>

        <!-- Alerts -->
        @if(session('warning'))
            <div class="sf-alert sf-alert-warning sf-fade-in mb-3">
                <i class="fas fa-exclamation-triangle"></i>
                <span><strong>Amaran:</strong> {{ session('warning') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="sf-alert sf-alert-danger sf-fade-in mb-3">
                <i class="fas fa-exclamation-circle"></i>
                <span><strong>Ralat:</strong> {{ session('error') }}</span>
            </div>
        @endif

        <!-- Download Options -->
        <div class="sf-download-box sf-fade-in">
            <h3>📥 Muat Turun Template Pelajar</h3>
            <p>Pilih format pilihan anda untuk memuat turun template muat naik pelajar</p>
            
            <div class="sf-download-buttons">
                <a href="{{ route('school.download-template') }}" class="sf-download-btn">
                    <i class="fas fa-file-excel"></i> Template Excel (Disyorkan)
                </a>
                
                <a href="{{ route('school.download-csv-template') }}" class="sf-download-btn">
                    <i class="fas fa-file-csv"></i> Template CSV (Alternatif)
                </a>
            </div>
            
            <div style="margin-top: 1rem; font-size: 0.9rem; opacity: 0.9;">
                💡 Jika muat turun Excel gagal, gunakan alternatif CSV atau salin jadual di bawah
            </div>
        </div>

        <!-- Instructions -->
        <div class="sf-instructions-box sf-fade-in" style="animation-delay: 0.1s;">
            <h2>📋 Arahan Template Muat Naik Pelajar</h2>
            <p><strong>Cara menggunakan template ini:</strong></p>
            <ol>
                <li>Isikan maklumat pelajar dalam baris di bawah tajuk</li>
                <li>Medan yang ditanda dengan <span class="sf-required-tag">*</span> adalah wajib</li>
                <li>Gunakan format tarikh yang ditunjukkan dalam contoh (YYYY-MM-DD)</li>
                <li>Tingkatan mestilah "Tingkatan 5" sahaja</li>
                <li>Padamkan baris contoh sebelum memuat naik</li>
                <li>Simpan dalam format Excel (.xlsx) apabila selesai</li>
            </ol>
            <p><strong>⚠️ Penting:</strong> Jangan tukar tajuk lajur atau susunannya</p>
        </div>

        <!-- Template Table -->
        <div class="sf-template-table sf-fade-in" style="animation-delay: 0.2s;">
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Pelajar <span class="sf-required-tag">*</span></th>
                            <th>No. Kad Pengenalan <span class="sf-required-tag">*</span></th>
                            <th>E-mel <span class="sf-optional-tag">(Pilihan)</span></th>
                            <th>Tingkatan <span class="sf-required-tag">*</span></th>
                            <th>No. Telefon Pelajar <span class="sf-optional-tag">(Pilihan)</span></th>
                            <th>Tarikh Lahir <span class="sf-optional-tag">(Pilihan)</span></th>
                            <th>Jantina <span class="sf-optional-tag">(Pilihan)</span></th>
                            <th>Nama Ibu Bapa/Penjaga <span class="sf-optional-tag">(Pilihan)</span></th>
                            <th>Telefon Ibu Bapa/Penjaga <span class="sf-optional-tag">(Pilihan)</span></th>
                            <th>Alamat <span class="sf-optional-tag">(Pilihan)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Data Rows -->
                        <tr class="sf-sample-row">
                            <td>Ahmad Bin Hassan</td>
                            <td>980123456789</td>
                            <td>ahmad.hassan@email.com</td>
                            <td>Tingkatan 5</td>
                            <td>012-345-6789</td>
                            <td>2008-05-15</td>
                            <td>Lelaki</td>
                            <td>Hassan Bin Ali</td>
                            <td>012-345-6790</td>
                            <td>123 Jalan Utama, Kuala Lumpur 50000</td>
                        </tr>
                        <tr class="sf-sample-row">
                            <td>Siti Binti Abdullah</td>
                            <td>010123456789</td>
                            <td>siti.abdullah@email.com</td>
                            <td>Tingkatan 5</td>
                            <td>012-345-6791</td>
                            <td>2009-03-22</td>
                            <td>Perempuan</td>
                            <td>Fatimah Binti Omar</td>
                            <td>012-345-6792</td>
                            <td>456 Jalan Oak, Petaling Jaya 47300</td>
                        </tr>
                        <tr class="sf-sample-row">
                            <td>Raj A/L Kumar</td>
                            <td>070810123456</td>
                            <td>raj.kumar@email.com</td>
                            <td>Tingkatan 5</td>
                            <td>012-345-6793</td>
                            <td>2007-08-10</td>
                            <td>Lelaki</td>
                            <td>Kumar A/L Raman</td>
                            <td>012-345-6794</td>
                            <td>789 Jalan Pine, Subang Jaya 47500</td>
                        </tr>
                        <!-- Empty rows for schools to fill -->
                        @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Field Descriptions -->
        <div class="sf-field-desc-box sf-fade-in" style="animation-delay: 0.3s;">
            <h3>📝 Penerangan Medan:</h3>
            <ul>
                <li><strong>Nama Pelajar:</strong> Nama penuh pelajar (gabungkan nama depan dan belakang)</li>
                <li><strong>No. Kad Pengenalan:</strong> Nombor kad pengenalan Malaysia (12 digit)</li>
                <li><strong>E-mel:</strong> Alamat e-mel pelajar (jika ada)</li>
                <li><strong>Tingkatan:</strong> Mesti "Tingkatan 5" sahaja</li>
                <li><strong>No. Telefon Pelajar:</strong> Nombor hubungan pelajar</li>
                <li><strong>Tarikh Lahir:</strong> Format: YYYY-MM-DD (cth: 2008-05-15)</li>
                <li><strong>Jantina:</strong> Lelaki, Perempuan, atau Lain-lain</li>
                <li><strong>Nama Ibu Bapa/Penjaga:</strong> Orang hubungan utama</li>
                <li><strong>Telefon Ibu Bapa/Penjaga:</strong> Nombor hubungan kecemasan</li>
                <li><strong>Alamat:</strong> Alamat rumah lengkap</li>
            </ul>
        </div>

        <div class="sf-field-desc-box sf-fade-in" style="animation-delay: 0.4s; border-left-color: var(--sf-mint-fresh);">
            <h3>✅ Peraturan Pengesahan:</h3>
            <ul>
                <li>Nama Pelajar dan No. Kad Pengenalan adalah <strong>wajib</strong></li>
                <li>No. Kad Pengenalan mesti 12 digit (format sebagai teks untuk mengekalkan sifar di hadapan)</li>
                <li>Tingkatan mesti tepat "Tingkatan 5"</li>
                <li>E-mel mesti dalam format yang sah (jika disediakan)</li>
                <li>Nombor telefon harus termasuk kod kawasan dan diformat sebagai teks</li>
                <li>Tarikh Lahir mesti dalam format YYYY-MM-DD</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="sf-footer">
        <div class="sf-footer-emojis">📝 📊 ✅</div>
        <p class="sf-footer-text">Template Muat Naik Pelajar - Kolej UNITI</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
