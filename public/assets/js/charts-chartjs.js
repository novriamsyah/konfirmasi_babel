/**
 * Charts ChartsJS
 */
'use strict';

(function () {
  // Color Variables
  const purpleColor = '#836AF9',
    yellowColor = '#ffe800',
    cyanColor = '#28dac6',
    orangeColor = '#FF8132',
    orangeLightColor = '#FDAC34',
    oceanBlueColor = '#299AFF',
    greyColor = '#4F5D70',
    greyLightColor = '#EDF1F4',
    blueColor = '#3b82f6',
    blueLightColor = '#eff6ff',
    redColor = '#f87171',
    redLightColor = '#fef2f2',
    amberLightColor = '#fff7ed',
    amberColor = '#f59e0b';

  let cardColor, headingColor, labelColor, borderColor, legendColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors.cardColor;
    headingColor = config.colors.headingColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
  }

  // Set height according to their data-height
  // --------------------------------------------------------------------
  const chartList = document.querySelectorAll('.chartjs');
  chartList.forEach(function (chartListItem) {
    chartListItem.height = chartListItem.dataset.height;
  });

  // Pie Chart
  // --------------------------------------------------------------------
  const pieChart = document.getElementById('pieChart');
  if (pieChart) {
    const pieChartVar = new Chart(pieChart, {
      type: 'pie',
        data: {
            labels: ['Daya Aktif', 'Daya reaktif', 'Daya Semu'],
            datasets: [{
                data: [50, 60, 70],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }],
        },
        options: {
            plugins: {
                datalabels: {
                    display: true,
                    align: 'bottom',
                    backgroundColor: '#ccc',
                    borderRadius: 3,
                    font: {
                        size: 18,
                    },
                    formatter: (value, context) => {
                        return context.chart.data.labels[context.dataIndex] + ': ' + value;
                    },
                },
            },
        },
    });
  }


  // LineArea Chart
  // --------------------------------------------------------------------

  const energiListrikChart = document.getElementById('energiListrikChart');
  if (energiListrikChart) {
    const energiListrikChartVar = new Chart(energiListrikChart, {
      type: 'line',
      data: {
        labels: [],
        datasets: [
          {
            label: 'Energi Listrik',
            data: [],
            tension: 0,
            fill: true,
            backgroundColor: '#ecfeff',
            pointStyle: 'circle',
            borderColor: blueColor,
            pointRadius: 0.5,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBackgroundColor: blueLightColor,
            pointHoverBorderColor: cardColor,
            datalabels: {
              align: 'start',
              anchor: 'start',
              color: '#000',
              backgroundColor: '#ecfeff',
              borderColor: '#000',
              borderRadius: 32,
              borderWidth: 1,
              font: {
              weight: 'bold',
              },
              offset: 1,
              padding: 5,
              textAlign: 'center'
          }
          },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            rtl: isRtl,
            align: 'start',
            labels: {
              usePointStyle: true,
              padding: 35,
              boxWidth: 6,
              boxHeight: 6,
              color: legendColor
            }
          },
          tooltip: {
            // Updated default tooltip UI
            rtl: isRtl,
            backgroundColor: cardColor,
            titleColor: headingColor,
            bodyColor: legendColor,
            borderWidth: 1,
            borderColor: borderColor
          }
        },
        scales: {
          x: {
            grid: {
              color: 'transparent',
              borderColor: borderColor
            },
            ticks: {
              color: labelColor
            }
          },
          y: {
            min: 0,
            max: 400,
            grid: {
              color: 'transparent',
              borderColor: borderColor
            },
            ticks: {
              stepSize: 100,
              color: labelColor
            }
          }
        }
      }
    });

    let updateChartEnergiListrik = function() {
      $.ajax({
       type: "GET",
       dataType: "json",
       url: '{{ route('collection.data.sensor') }}',
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data) {
         console.log(data);
       },
       error: function(data){
         console.log(data);
       }
      });
      }
      updateChartEnergiListrik();
      setInterval(() => {
      updateChartEnergiListrik();
      }, 1000);
  }

  const lineAreaChart2 = document.getElementById('lineAreaChart2');
  if (lineAreaChart2) {
    const lineAreaChartVar = new Chart(lineAreaChart2, {
      type: 'line',
      data: {
        labels: [
          '7/12',
          '8/12',
          '9/12',
          '10/12',
          '11/12',
          '12/12',
          '13/12',
          '14/12',
          '15/12',
          '16/12',
          '17/12',
          '18/12',
          '19/12',
          '20/12',
          ''
        ],
        datasets: [
          {
            label: 'Tegangan Listrik',
            labelColor: amberColor,
            data: [40, 55, 45, 75, 65, 55, 70, 60, 100, 98, 90, 120, 125, 140, 155],
            tension: 0,
            fill: true,
            backgroundColor: amberLightColor,
            pointStyle: 'circle',
            borderColor: amberColor,
            pointRadius: 0.5,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBackgroundColor: blueColor,
            pointHoverBorderColor: cardColor,
            datalabels: {
              align: 'start',
              anchor: 'start',
              color: '#000',
              backgroundColor: amberLightColor,
              borderColor: '#000',
              borderRadius: 32,
              borderWidth: 1,
              font: {
              weight: 'bold',
              },
              offset: 1,
              padding: 5,
              textAlign: 'center'
          }
          },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            rtl: isRtl,
            align: 'start',
            labels: {
              usePointStyle: true,
              padding: 35,
              boxWidth: 6,
              boxHeight: 6,
              color: legendColor
            }
          },
          tooltip: {
            // Updated default tooltip UI
            rtl: isRtl,
            backgroundColor: cardColor,
            titleColor: headingColor,
            bodyColor: legendColor,
            borderWidth: 1,
            borderColor: borderColor
          }
        },
        scales: {
          x: {
            grid: {
              color: 'transparent',
              borderColor: borderColor
            },
            ticks: {
              color: labelColor
            }
          },
          y: {
            min: 0,
            max: 400,
            grid: {
              color: 'transparent',
              borderColor: borderColor
            },
            ticks: {
              stepSize: 100,
              color: labelColor
            }
          }
        }
      }
    });
  }

  const lineAreaChart3 = document.getElementById('lineAreaChart3');
  if (lineAreaChart3) {
    const lineAreaChartVar = new Chart(lineAreaChart3, {
      type: 'line',
      data: {
        labels: [
          '7/12',
          '8/12',
          '9/12',
          '10/12',
          '11/12',
          '12/12',
          '13/12',
          '14/12',
          '15/12',
          '16/12',
          '17/12',
          '18/12',
          '19/12',
          '20/12',
          ''
        ],
        datasets: [
          {
            label: 'Arus Listrik',
            data: [240, 195, 160, 215, 185, 215, 185, 200, 250, 210, 195, 250, 235, 300, 315],
            tension: 0,
            fill: true,
            backgroundColor: redLightColor,
            pointStyle: 'circle',
            borderColor: redColor,
            pointRadius: 0.5,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBackgroundColor: greyLightColor,
            pointHoverBorderColor: cardColor,
            datalabels: {
              align: 'start',
              anchor: 'start',
              color: '#000',
              backgroundColor: redLightColor,
              borderColor: '#000',
              borderRadius: 32,
              borderWidth: 1,
              font: {
              weight: 'bold',
              },
              offset: 1,
              padding: 5,
              textAlign: 'center'
          }
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            rtl: isRtl,
            align: 'start',
            labels: {
              usePointStyle: true,
              padding: 35,
              boxWidth: 6,
              boxHeight: 6,
              color: legendColor
            }
          },
          tooltip: {
            // Updated default tooltip UI
            rtl: isRtl,
            backgroundColor: cardColor,
            titleColor: headingColor,
            bodyColor: legendColor,
            borderWidth: 1,
            borderColor: borderColor
          }
        },
        scales: {
          x: {
            grid: {
              color: 'transparent',
              borderColor: borderColor
            },
            ticks: {
              color: labelColor
            }
          },
          y: {
            min: 0,
            max: 400,
            grid: {
              color: 'transparent',
              borderColor: borderColor
            },
            ticks: {
              stepSize: 100,
              color: labelColor
            }
          }
        }
      }
    });
  }
})();
