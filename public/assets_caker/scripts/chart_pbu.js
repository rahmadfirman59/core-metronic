// Pengangguran Berdasarkan Usia Chart
const pbuCtx = document.getElementById('pengangguranBerdasarkanUsiaChart');
const doughnutChart = new Chart(pbuCtx, {
  type: 'doughnut',
  data: {
    labels: [
      '50 - 70',
      '30 - 50',
      '< 30'
    ],
    datasets: [{
      data: [300, 50, 100],
      backgroundColor: [
        'rgb(63, 133, 237)',
        'rgb(3, 166, 120)',
        'rgb(111, 106, 134)',
      ],
      hoverOffset: 4,
      rotation: 90,
      borderWidth: 0,
    }]
  },
  options: {
    layout: {
      padding: 20,
    },
    plugins: {
      legend: {
        position: 'bottom',
        labels: {
          boxWidth: 10,
          padding: 30,
          usePointStyle: true,
          pointStyle: 'circle',
        },
      },
    },
  },
});