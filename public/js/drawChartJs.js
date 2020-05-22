function checkAndGenBackgColor(countOfLables, opacity) {
	countOfLables = countOfLables <= 0 ? 5 : countOfLables;
	opacity = opacity ? opacity : 0.2;
	const MIN = 0;
	const MAX = 255;
	let rgbaArr = [];
	let num1, num2, num3;
	for (let i = 0; i < countOfLables; i++) {
		num1 = parseInt(Math.random() * (MAX - MIN) + MIN);
		num2 = parseInt(Math.random() * (MAX - MIN) + MIN);
		num3 = parseInt(Math.random() * (MAX - MIN) + MIN);
		let rgba = `rgba(${num1}, ${num2}, ${num3}, ${opacity})`;
		rgbaArr.push(rgba);
	}

	return rgbaArr;
}

function drawChartJS(options) {
	// console.log(checkAndGenBackgColor(5, 0.2));
	const ctx = options.ctx ? options.ctx : 'myChart';
	let myChart = new Chart(ctx, {
		type: options.type ? options.type : 'bar',
		data: {
			// labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
			labels: options.labels ? options.labels : [ 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange' ],
			datasets: [
				{
					label: options.label ? options.label : '# of Votes',
					// data: [12, 19, 3, 5, 2, 3],
					data: options.data ? options.data : [ 12, 19, 3, 5, 2, 3 ],
					backgroundColor:
						options.backgroundColor && options.backgroundColor.length > 0
							? options.backgroundColor
							: checkAndGenBackgColor(options.labels.length - 1),
					borderWidth: options.borderWidth ? options.borderWidth : 1
				}
			]
		},
		options: {
			scales: {
				yAxes: [
					{
						ticks: {
							beginAtZero: options.beginAtZero ? options.beginAtZero : false
						}
					}
				]
			}
		}
	});
}
