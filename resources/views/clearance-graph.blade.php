<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Applications Graph</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f4f8;
        }
        .container {
            width: 80%;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        .chart-container {
            margin-bottom: 20px;
            height: 400px;
        }
        .print-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .print-btn:hover {
            background-color: #2980b9;
        }
        .filter-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .filter-container select {
            padding: 5px 10px;
            font-size: 16px;
        }
        .statistics {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .statistics h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .statistics p {
            margin: 5px 0;
            color: #34495e;
        }
        @media print {
            body {
                background-color: white;
            }
            .container {
                width: 100%;
                box-shadow: none;
            }
            .print-btn, .filter-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    @include('partials.nav')
    <div class="container">
        <h1>Clearance Applications Received ({{ ucfirst($filter) }})</h1>
        <div class="filter-container">
            <select id="filterSelect">
                <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly" {{ $filter == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
        </div>
        <div class="chart-container">
            <canvas id="lineChart"></canvas>
        </div>
        <div class="statistics">
            <h2>Statistics</h2>
            <div id="statsContent"></div>
        </div>
        <button class="print-btn" onclick="window.print()">Download Report</button>
    </div>

    <script>
        // Embed PHP data into JavaScript
        const dates = <?php echo json_encode($dates); ?>;
        const counts = <?php echo json_encode($counts); ?>;
        const filter = "<?php echo $filter; ?>";
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const gradient = lineCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(52, 152, 219, 0.6)');
        gradient.addColorStop(1, 'rgba(52, 152, 219, 0)');

        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Applications Received',
                    data: counts,
                    borderColor: 'rgba(52, 152, 219, 1)',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3498db',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Date',
                            color: '#7f8c8d',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#7f8c8d',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(127, 140, 141, 0.2)'
                        },
                        title: {
                            display: true,
                            text: 'Number of Applications',
                            color: '#7f8c8d',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 10,
                        cornerRadius: 4
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });

        document.getElementById('filterSelect').addEventListener('change', function() {
            window.location.href = '?filter=' + this.value;
        });

        function calculateStats() {
            const total = counts.reduce((sum, count) => sum + count, 0);
            const average = (total / counts.length).toFixed(2);
            const highest = Math.max(...counts);
            const lowest = Math.min(...counts);
            const highestDate = dates[counts.indexOf(highest)];
            const lowestDate = dates[counts.indexOf(lowest)];

            return { total, average, highest, lowest, highestDate, lowestDate };
        }

        function displayStats() {
            const stats = calculateStats();
            const statsContent = document.getElementById('statsContent');
            statsContent.innerHTML = `
                <p><strong>Total Applications:</strong> ${stats.total}</p>
                <p><strong>Average Applications per ${ucfirst(filter)}:</strong> ${stats.average}</p>
                <p><strong>Highest Number of Applications:</strong> ${stats.highest} (on ${stats.highestDate})</p>
                <p><strong>Lowest Number of Applications:</strong> ${stats.lowest} (on ${stats.lowestDate})</p>
            `;
        }

        function ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        displayStats();
    </script>
</body>
</html>
