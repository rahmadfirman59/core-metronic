// Pertumbuhan Angka Pengangguran Chart
const papCtx = document.getElementById('pertumbuhanAngkaPengangguranChart');
const lineChart = new Chart(papCtx, {
  type: 'line',
  data: {
    labels: [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
    ],
    datasets: [{
      data: [65, 59, 80, 81, 56, 55, 40],
      fill: {
        target: 'origin',
        above: 'rgba(63, 133, 237, 0.5)',
        below: 'rgba(63, 133, 237, 0.5)',
      },
      borderColor: 'rgb(63, 133, 237)',
      borderJoinStyle: 'round',
      borderCapStyle: 'round',
      tension: 0.5,
    }]
  },
  options: {
    plugins: {
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  }
});