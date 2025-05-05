@extends('layouts.app')

@section('konten')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Prediksi UMKM - Linear Regression</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/11.5.0/math.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background-color: #0077b6;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        h1 {
            margin: 0;
            font-size: 28px;
        }
        .dashboard {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px;
            flex: 1;
            min-width: 280px;
        }
        .card h2 {
            margin-top: 0;
            font-size: 18px;
            color: #0077b6;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        input, select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            background-color: #0077b6;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #00598a;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        .data-table th {
            background-color: #f2f2f2;
        }
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        .stat-item {
            background-color: #e9f2f9;
            border-radius: 4px;
            padding: 10px 15px;
            font-size: 14px;
            flex: 1;
            min-width: 120px;
            text-align: center;
        }
        .stat-value {
            font-weight: bold;
            font-size: 18px;
            color: #0077b6;
            display: block;
        }
        .product-select {
            margin-bottom: 20px;
        }
        .prediction-highlight {
            background-color: #e6f7ff;
            border-left: 4px solid #0077b6;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Aplikasi Prediksi Permintaan Produk UMKM</h1>
            <p>Prediksi penjualan produk menggunakan metode Linear Regression</p>
        </header>

        <div class="dashboard">
            <div class="card">
                <h2>Pilih Produk</h2>
                <div class="form-group product-select">
                    <label for="product">Produk:</label>
                    <select id="product" onchange="changeProduct()">
                        <option value="batik">Batik Tulis Tradisional</option>
                        <option value="kerajinan">Kerajinan Anyaman Bambu</option>
                        <option value="makanan">Makanan Khas Daerah</option>
                        <option value="gerabah">Gerabah Tradisional</option>
                        <option value="tenun">Kain Tenun Ikat</option>
                        <option value="perak">Perhiasan Perak</option>
                        <option value="bordir">Baju Bordir</option>
                        <option value="tempe">Keripik Tempe</option>
                        <option value="mebel">Mebel Kayu Jati</option>
                        <option value="keramik">Keramik Hias</option>
                        <option value="songket">Kain Songket</option>
                        <option value="kulit">Produk Kerajinan Kulit</option>
                        <option value="snack">Camilan Tradisional</option>
                    </select>
                </div>
                
                <h2>Data Historis</h2>
                <div id="historicalData">
                    <table class="data-table" id="dataTable">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Permintaan</th>
                            </tr>
                        </thead>
                        <tbody id="dataBody">
                            <!-- Data akan diisi melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <div class="form-group" style="margin-top: 20px;">
                    <label for="months">Jumlah Bulan Prediksi:</label>
                    <input type="number" id="months" min="1" max="12" value="6">
                </div>
                
                <button onclick="predictDemand()">Hitung Prediksi</button>
            </div>
            
            <div class="card">
                <h2>Grafik Permintaan & Prediksi</h2>
                <div class="chart-container">
                    <canvas id="demandChart"></canvas>
                </div>
                
                <div class="stats">
                    <div class="stat-item">
                        <span>Rata-rata Permintaan</span>
                        <span class="stat-value" id="avgDemand">0</span>
                    </div>
                    <div class="stat-item">
                        <span>Penjualan Tertinggi</span>
                        <span class="stat-value" id="maxDemand">0</span>
                    </div>
                    <div class="stat-item">
                        <span>Tren</span>
                        <span class="stat-value" id="trendValue">-</span>
                    </div>
                </div>
                
                <div class="prediction-highlight">
                    <h3>Hasil Prediksi</h3>
                    <p id="predictionSummary">Pilih produk dan klik "Hitung Prediksi" untuk melihat hasil.</p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>Prediksi Permintaan Bulan Mendatang</h2>
            <table class="data-table" id="predictionTable">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Prediksi Permintaan</th>
                    </tr>
                </thead>
                <tbody id="predictionBody">
                    <!-- Prediksi akan diisi melalui JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Data produk UMKM (data historis 12 bulan terakhir)
        const productData = {
            batik: {
                name: "Batik Tulis Tradisional",
                data: [45, 52, 48, 60, 55, 70, 62, 68, 75, 80, 85, 90],
                unit: "pcs"
            },
            kerajinan: {
                name: "Kerajinan Anyaman Bambu",
                data: [120, 115, 130, 142, 125, 150, 160, 155, 175, 185, 190, 210],
                unit: "pcs"
            },
            makanan: {
                name: "Makanan Khas Daerah",
                data: [350, 320, 380, 400, 430, 450, 420, 470, 500, 520, 540, 580],
                unit: "paket"
            },
            gerabah: {
                name: "Gerabah Tradisional",
                data: [65, 58, 70, 75, 72, 80, 85, 90, 95, 92, 100, 110],
                unit: "pcs"
            },
            tenun: {
                name: "Kain Tenun Ikat",
                data: [30, 32, 28, 35, 38, 40, 45, 42, 48, 52, 55, 60],
                unit: "lembar"
            },
            perak: {
                name: "Perhiasan Perak",
                data: [25, 22, 28, 30, 32, 35, 38, 40, 42, 45, 48, 52],
                unit: "pcs"
            },
            bordir: {
                name: "Baju Bordir",
                data: [85, 90, 88, 95, 100, 105, 110, 115, 120, 128, 135, 142],
                unit: "pcs"
            },
            tempe: {
                name: "Keripik Tempe",
                data: [420, 435, 410, 450, 460, 480, 500, 520, 540, 560, 580, 600],
                unit: "bungkus"
            },
            mebel: {
                name: "Mebel Kayu Jati",
                data: [8, 10, 7, 12, 9, 11, 13, 15, 14, 16, 18, 20],
                unit: "set"
            },
            keramik: {
                name: "Keramik Hias",
                data: [55, 60, 58, 65, 70, 68, 72, 75, 80, 85, 90, 95],
                unit: "pcs"
            },
            songket: {
                name: "Kain Songket",
                data: [15, 18, 16, 20, 22, 25, 23, 28, 30, 32, 35, 38],
                unit: "lembar"
            },
            kulit: {
                name: "Produk Kerajinan Kulit",
                data: [40, 45, 42, 48, 50, 55, 58, 60, 65, 70, 75, 80],
                unit: "pcs"
            },
            snack: {
                name: "Camilan Tradisional",
                data: [280, 300, 290, 310, 330, 350, 370, 390, 410, 430, 450, 480],
                unit: "bungkus"
            }
        };

        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        
        // Mulai dari bulan saat ini - 12 bulan
        const currentMonth = new Date().getMonth();
        const pastMonths = [];
        
        for (let i = 11; i >= 0; i--) {
            let monthIndex = (currentMonth - i + 12) % 12;
            pastMonths.push(months[monthIndex]);
        }

        let currentProduct = "batik";
        let chart = null;

        // Inisialisasi aplikasi
        function init() {
            changeProduct();
        }

        // Mengganti produk yang dipilih
        function changeProduct() {
            currentProduct = document.getElementById("product").value;
            displayHistoricalData();
            
            if (chart) {
                chart.destroy();
            }
            
            createChart(productData[currentProduct].data, []);
            calculateStats();
            document.getElementById("predictionSummary").innerHTML = "Pilih produk dan klik \"Hitung Prediksi\" untuk melihat hasil.";
            document.getElementById("predictionBody").innerHTML = "";
        }

        // Menampilkan data historis dalam tabel
        function displayHistoricalData() {
            const tableBody = document.getElementById("dataBody");
            tableBody.innerHTML = "";
            
            const data = productData[currentProduct].data;
            
            for (let i = 0; i < data.length; i++) {
                const row = document.createElement("tr");
                
                const monthCell = document.createElement("td");
                monthCell.textContent = pastMonths[i];
                row.appendChild(monthCell);
                
                const demandCell = document.createElement("td");
                demandCell.textContent = data[i] + " " + productData[currentProduct].unit;
                row.appendChild(demandCell);
                
                tableBody.appendChild(row);
            }
        }

        // Membuat grafik dengan Chart.js
        function createChart(historicalData, predictionData) {
            const ctx = document.getElementById('demandChart').getContext('2d');
            
            const labels = [...pastMonths];
            const nextMonths = [];
            
            // Menambahkan bulan-bulan berikutnya untuk prediksi
            if (predictionData.length > 0) {
                let lastMonthIndex = pastMonths.length > 0 ? 
                    months.indexOf(pastMonths[pastMonths.length - 1]) : currentMonth;
                
                for (let i = 1; i <= predictionData.length; i++) {
                    let nextMonthIndex = (lastMonthIndex + i) % 12;
                    nextMonths.push(months[nextMonthIndex]);
                    labels.push(months[nextMonthIndex]);
                }
            }
            
            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Data Historis',
                            data: historicalData,
                            borderColor: '#0077b6',
                            backgroundColor: 'rgba(0, 119, 182, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.1
                        },
                        {
                            label: 'Prediksi',
                            data: Array(historicalData.length).fill(null).concat(predictionData),
                            borderColor: '#ff9500',
                            backgroundColor: 'rgba(255, 149, 0, 0.1)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: true,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Permintaan (' + productData[currentProduct].unit + ')'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y + ' ' + productData[currentProduct].unit;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
            
            return nextMonths;
        }

        // Menghitung statistik dasar dari data historis
        function calculateStats() {
            const data = productData[currentProduct].data;
            const sum = data.reduce((a, b) => a + b, 0);
            const avg = Math.round(sum / data.length);
            const max = Math.max(...data);
            
            // Deteksi tren
            const firstHalf = data.slice(0, Math.floor(data.length / 2));
            const secondHalf = data.slice(Math.floor(data.length / 2));
            const firstAvg = firstHalf.reduce((a, b) => a + b, 0) / firstHalf.length;
            const secondAvg = secondHalf.reduce((a, b) => a + b, 0) / secondHalf.length;
            
            let trend = "Stabil";
            let trendColor = "#888";
            
            if (secondAvg > firstAvg * 1.1) {
                trend = "Naik ↑";
                trendColor = "#28a745";
            } else if (secondAvg < firstAvg * 0.9) {
                trend = "Turun ↓";
                trendColor = "#dc3545";
            }
            
            document.getElementById("avgDemand").textContent = avg + " " + productData[currentProduct].unit;
            document.getElementById("maxDemand").textContent = max + " " + productData[currentProduct].unit;
            document.getElementById("trendValue").textContent = trend;
            document.getElementById("trendValue").style.color = trendColor;
        }

        // Prediksi permintaan menggunakan linear regression
        function predictDemand() {
            const months = parseInt(document.getElementById("months").value);
            
            if (isNaN(months) || months < 1 || months > 12) {
                alert("Masukkan jumlah bulan prediksi antara 1-12");
                return;
            }
            
            const historicalData = productData[currentProduct].data;
            const xValues = Array.from({length: historicalData.length}, (_, i) => i + 1);
            const yValues = historicalData;
            
            // Menghitung koefisien linear regression menggunakan math.js
            const xMean = math.mean(xValues);
            const yMean = math.mean(yValues);
            
            let numerator = 0;
            let denominator = 0;
            
            for (let i = 0; i < xValues.length; i++) {
                numerator += (xValues[i] - xMean) * (yValues[i] - yMean);
                denominator += Math.pow(xValues[i] - xMean, 2);
            }
            
            const slope = numerator / denominator;
            const intercept = yMean - (slope * xMean);
            
            // Menghitung prediksi
            const predictions = [];
            for (let i = 1; i <= months; i++) {
                const x = xValues.length + i;
                const prediction = Math.round(intercept + (slope * x));
                predictions.push(Math.max(0, prediction)); // Pastikan prediksi tidak negatif
            }
            
            // Memperbarui grafik dengan data prediksi
            if (chart) {
                chart.destroy();
            }
            
            const nextMonths = createChart(historicalData, predictions);
            displayPredictions(predictions, nextMonths);
            
            // Memperbarui ringkasan prediksi
            updatePredictionSummary(predictions, slope);
        }

        // Menampilkan hasil prediksi dalam tabel
        function displayPredictions(predictions, months) {
            const tableBody = document.getElementById("predictionBody");
            tableBody.innerHTML = "";
            
            for (let i = 0; i < predictions.length; i++) {
                const row = document.createElement("tr");
                
                const monthCell = document.createElement("td");
                monthCell.textContent = months[i];
                row.appendChild(monthCell);
                
                const predictionCell = document.createElement("td");
                predictionCell.textContent = predictions[i] + " " + productData[currentProduct].unit;
                row.appendChild(predictionCell);
                
                tableBody.appendChild(row);
            }
        }

        // Memperbarui ringkasan prediksi
        function updatePredictionSummary(predictions, slope) {
            const productName = productData[currentProduct].name;
            const unit = productData[currentProduct].unit;
            
            const historicalAvg = math.mean(productData[currentProduct].data);
            const predictionAvg = math.mean(predictions);
            
            let trendText = "stabil";
            let percentChange = ((predictionAvg - historicalAvg) / historicalAvg * 100).toFixed(1);
            
            if (slope > 0) {
                trendText = `meningkat sekitar ${percentChange}%`;
            } else if (slope < 0) {
                trendText = `menurun sekitar ${Math.abs(percentChange)}%`;
            }
            
            const lastValue = productData[currentProduct].data[productData[currentProduct].data.length - 1];
            const lastPrediction = predictions[predictions.length - 1];
            
            let summary = `
                <p>Berdasarkan analisis data historis 12 bulan terakhir, permintaan produk <strong>${productName}</strong> 
                diprediksi akan ${trendText} dalam ${predictions.length} bulan mendatang.</p>
                
                <p>Rata-rata permintaan historis adalah <strong>${Math.round(historicalAvg)} ${unit}</strong>, 
                sedangkan rata-rata permintaan yang diprediksi adalah <strong>${Math.round(predictionAvg)} ${unit}</strong>.</p>
                
                <p>Prediksi permintaan bulan terakhir adalah <strong>${lastPrediction} ${unit}</strong> 
                dibandingkan dengan data terakhir <strong>${lastValue} ${unit}</strong>.</p>
            `;
            
            document.getElementById("predictionSummary").innerHTML = summary;
        }

        // Inisialisasi aplikasi saat halaman dimuat
        window.onload = init;
    </script>
</body>
</html>
@endsection