// Distribusi Pekerjaan Chart
const dpCtx = document.getElementById('distribusiPekerjaanChart');
const barChart = new Chart(dpCtx, {
  type: 'bar',
  data: {
    labels: ['Wiraswasta', 'Pelajar', 'Swasta', 'PNS', 'Guru', 'Pedagang', 'Buruh Pabrik', 'Lain-lain'],
    datasets: [{
      data: [50, 49, 47, 45, 39, 36, 32, 29],
      backgroundColor: [
        'rgba(3, 166, 120, 1)',
        'rgba(3, 166, 120, 0.9)',
        'rgba(3, 166, 120, 0.8)',
        'rgba(3, 166, 120, 0.7)',
        'rgba(3, 166, 120, 0.6)',
        'rgba(3, 166, 120, 0.5)',
        'rgba(3, 166, 120, 0.4)',
        'rgba(3, 166, 120, 0.3)',
      ],
      barPercentage: 1,
      categoryPercentage: 1,
    }]
  },
  options: {
    plugins: {
      legend: {
        display: false
      }
    },
    indexAxis: 'y',
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});