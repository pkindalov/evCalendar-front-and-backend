let eventCalendar = (function(calendarContainerId) {
	let that = this;
	that.container = null;
	that.calendar = null;
	that.calendarBody = null;
	that.calendarTable = null;
	that.currentMonthNum = null;
	that.currentMontName = null;
	that.currentMontCountOfDays = null;
	that.currentYear = null;
	that.currentlySelectedDay = null;
	that.indexToStartDays = null;
	that.firstDayOfMonth = null;
	that.todayNum = null;
	that.eventsContainer = null;
	that.eventWindowToggled = false;
	that.eventsData = [];
	that.eventsPagStartIndex = 0;
	that.eventsPagIndex = 5;
	that.eventsPageSize = 5;
	that.eventsResult = null;
	that.userNotifPermission = false;
	that.intervalCheckEventsNot = null;
	(that.useThemes = true),
		(that.darkThemes = [ 'darkTheme1', 'darkTheme2', 'darkTheme3', 'darkTheme4', 'darkTheme5', 'darkTheme6' ]);
	that.colorfulThemes = [
		'colorfulTheme1',
		'colorfulTheme2',
		'colorfulTheme3',
		'colorfulTheme4',
		'colorfulTheme5',
		'colorfulTheme6'
	];
	that.mainTheme = that.darkThemes[0];
	that.language = 'en';
	that.monthsBg = [
		'Януари',
		'Февруари',
		'Март',
		'Април',
		'Май',
		'Юни',
		'Юли',
		'Август',
		'Септември',
		'Октомври',
		'Ноември',
		'Декември'
	];
	that.monthsEn = [
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
	];
	that.nameOfDaysEn = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ];
	that.nameOfDaysBg = [ 'Понеделник', 'Вторник', 'Сряда', 'Четвъртък', 'Петък', 'Събота', 'Неделя' ];
	that.eventsLabelsEn = [
		'Previous week events',
		'Next week events',
		'No events',
		'Begin',
		'Finish',
		'Text',
		'Date',
		'Events on this day',
		'Events this month',
		'Checked event'
	];
	that.eventsLabelsBg = [
		'Събития миналата седмица',
		'Събития следващата седмица',
		'Няма събития',
		'Започване',
		'Приключване',
		'Текст',
		'Дата',
		'Събития на този ден',
		'Събития този месец',
		'Отметнато събитие'
	];
	that.buttonLabelsEn = [
		'Add event',
		'Edit',
		'Delete',
		'Check/Uncheck',
		'Show Events',
		'Show More',
		'Show Previous',
		'Edit event',
		'Clear'
	];
	that.buttonLabelsBg = [
		'Добави събитие',
		'Редактирай',
		'Изтрий',
		'Маркирай/Отмаркирай',
		'Покажи събития',
		'Покажи още',
		'Предишни',
		'Редактирай събитие',
		'Изчисти'
	];

	//arrays used by getTranslatedWord method. If there is other languages arrays must be put here.
	that.allBgLabels = [ that.eventsLabelsBg, that.buttonLabelsBg, that.nameOfDaysBg ];
	that.allEnLabels = [ that.eventsLabelsEn, that.buttonLabelsEn, that.nameOfDaysEn ];

	function eventCalendar(config) {
		if (config && config.constructor === Object) {
			let keys = Object.keys(config);

			for (let key of keys) {
				switch (key) {
					case 'calendarContainer':
						this.setContainer(config[key]);
						break;
					case 'usingThemes':
						this.setUseOfThemes(config[key]);
						break;
					case 'calendarEventsData':
						this.setData(config[key]);
						break;
					case 'language':
						this.setLanguage(config[key]);
						break;
					case 'notifications':
						this.setUserNotifPermission(config[key]);
						break;
				}
			}
		}
		// console.log(config.constructor === Object);
		// console.log(typeof config === 'object' && config !== null);
	}

	eventCalendar.prototype.setContainer = function(calendarContainerId) {
		if (!document.getElementById(calendarContainerId)) {
			throw new Error(
				'Not found calendar container with id ' + calendarContainerId + '. Please pass valid id of container'
			);
			return;
		}

		that.container = document.getElementById(calendarContainerId);
	};

	eventCalendar.prototype.setEventsContainer = function(eventsContainerId) {
		if (!document.getElementById(eventsContainerId)) {
			throw new Error(
				'Not found event container with id ' + eventsContainerId + '. Please pass valid id of container'
			);
			return;
		}

		that.eventsContainer = document.getElementById(eventsContainerId);
	};

	eventCalendar.prototype.sortDataEventsByDate = function(data) {
		data.sort((a, b) => {
			return new Date(a.date) - new Date(b.date);
			// a = a.date.split('-').reverse().join('');
			// b = b.date.split('-').reverse().join('');
			// return a > b ? 1 : a < b ? -1 : 0;
		});

		return data;
	};

	eventCalendar.prototype.setData = function(data) {
		if (!data) {
			throw new Error('Invalid data. Please give array with objects');
			return;
		}

		that.eventsData = this.sortDataEventsByDate(data);
	};

	eventCalendar.prototype.setCurrentMonthNum = function(date) {
		return date.getMonth();
	};

	eventCalendar.prototype.setCurrentMonthName = function(monthNum) {
		switch (that.language) {
			case 'en':
				return that.monthsEn[monthNum];
			case 'bg':
				return that.monthsBg[monthNum];
			default:
				return that.monthsEn[monthNum];
		}
	};

	eventCalendar.prototype.setCurrentYear = function(date) {
		return date.getFullYear();
	};

	eventCalendar.prototype.setFirstDayOfMonth = function(year, month) {
		// return new Date(that.currentYear, that.currentMonthNum, 1).toString().split(' ')[0];
		return new Date(year, month, 1).toString().split(' ')[0];
	};

	eventCalendar.prototype.setindexToStartDays = function(dayName) {
		switch (dayName) {
			case 'Mon':
				return 0;
				break;
			case 'Tue':
				return 1;
				break;
			case 'Wed':
				return 2;
				break;
			case 'Thu':
				return 3;
				break;
			case 'Fri':
				return 4;
				break;
			case 'Sat':
				return 5;
				break;
			case 'Sun':
				return 6;
				break;
			default:
				throw error('No valid dayName');
		}
	};

	eventCalendar.prototype.setCurrentMontCountOfDays = function(year, month) {
		// return new Date(that.currentYear, that.currentMonthNum + 1, 0).getDate();
		return new Date(year, month, 0).getDate();
	};

	eventCalendar.prototype.setTodayNum = function(date) {
		return date.getDate();
	};

	eventCalendar.prototype.getTodayNum = function() {
		that.todayNum = this.setTodayNum(new Date());
		return that.todayNum;
	};

	eventCalendar.prototype.setThemeAllContainers = function() {
		document.getElementsByClassName('container')[0].classList.remove();
		document.getElementsByClassName('container')[0].setAttribute('class', `container ${that.mainTheme}`);
	};

	eventCalendar.prototype.setUseOfThemes = function(useTheme) {
		if (typeof useTheme !== 'boolean') {
			// throw new Error('Variable of setUseOfTheme method must be of type boolean');
			try{
				useTheme = Boolean(useTheme);
			}catch(err){
				console.log('Variable of setUseOfTheme method must be of type boolean');
				return;
			}
		}
		that.useThemes = useTheme;
	};

	eventCalendar.prototype.setUserNotifPermission = function(useNotifications){
		if (typeof useNotifications !== 'boolean') {
			// throw new Error('Variable of setUseOfTheme method must be of type boolean');
			try{
				useNotifications = Boolean(useNotifications);
			}catch(err){
				console.log('Variable of setUserNotifPermission method must be of type boolean');
				return;
			}
		}
		that.userNotifPermission = useNotifications;
	};

	eventCalendar.prototype.setLanguage = function(language) {
		if (!language) {
			console.log('Not valid language value.');
			return;
		}

		that.language = language;
	};

	eventCalendar.prototype.checkAndCloseOpenedDateWindow = function() {
		if (that.eventWindowToggled) {
			this.closeShowDateWindow();
			that.eventWindowToggled = false;
		}
	};

	eventCalendar.prototype.prevMonth = function() {
		that.currentMonthNum <= 0 ? (that.currentMonthNum = 11) : --that.currentMonthNum;
		document.getElementById('monthLabel').textContent = this.setCurrentMonthName(that.currentMonthNum);
		that.currentMontCountOfDays = this.setCurrentMontCountOfDays(that.currentYear, that.currentMonthNum + 1);
		that.firstDayOfMonth = this.setFirstDayOfMonth(that.currentYear, that.currentMonthNum);
		that.indexToStartDays = this.setindexToStartDays(that.firstDayOfMonth);
		that.mainTheme = !that.useThemes ? '' : this.addThemeForMonth(that.currentMonthNum);
		this.checkAndCloseOpenedDateWindow();
		this.setThemeAllContainers();
		this.drawCalendarBody();
		this.checkRecentlyPastEvents();
	};

	eventCalendar.prototype.nextMonth = function() {
		that.currentMonthNum >= 11 ? (that.currentMonthNum = 0) : ++that.currentMonthNum;
		document.getElementById('monthLabel').textContent = this.setCurrentMonthName(that.currentMonthNum);
		that.currentMontCountOfDays = this.setCurrentMontCountOfDays(that.currentYear, that.currentMonthNum + 1);
		that.firstDayOfMonth = this.setFirstDayOfMonth(that.currentYear, that.currentMonthNum);
		that.indexToStartDays = this.setindexToStartDays(that.firstDayOfMonth);
		that.mainTheme = !that.useThemes ? '' : this.addThemeForMonth(that.currentMonthNum);
		this.checkAndCloseOpenedDateWindow();
		this.setThemeAllContainers();
		this.drawCalendarBody();
		this.checkRecentlyPastEvents();
	};

	eventCalendar.prototype.getYearEventData = function(year) {
		fetch(`events/getUserEventsYear/${year}`)
			.then((response) => {
				return response.json();
			})
			.then((data) => {
				this.setData(data);
				this.drawCalendarBody();
			});
	};

	eventCalendar.prototype.prevYear = function() {
		that.currentYear--;
		document.getElementById('yearLabel').textContent = that.currentYear;
		that.currentMontCountOfDays = this.setCurrentMontCountOfDays(that.currentYear, that.currentMonthNum + 1);
		that.firstDayOfMonth = this.setFirstDayOfMonth(that.currentYear, that.currentMonthNum);
		that.indexToStartDays = this.setindexToStartDays(that.firstDayOfMonth);
		this.checkAndCloseOpenedDateWindow();
		this.getYearEventData(that.currentYear);
	};

	eventCalendar.prototype.nextYear = function() {
		that.currentYear++;
		document.getElementById('yearLabel').textContent = that.currentYear;
		that.currentMontCountOfDays = this.setCurrentMontCountOfDays(that.currentYear, that.currentMonthNum + 1);
		that.firstDayOfMonth = this.setFirstDayOfMonth(that.currentYear, that.currentMonthNum);
		that.indexToStartDays = this.setindexToStartDays(that.firstDayOfMonth);
		this.checkAndCloseOpenedDateWindow();
		this.getYearEventData(that.currentYear);
	};

	eventCalendar.prototype.checkNameOfDayDiffLang = function(dayIndex) {
		switch (that.language) {
			case 'en':
				return that.nameOfDaysEn[dayIndex];
			case 'bg':
				return that.nameOfDaysBg[dayIndex];
			default:
				throw new Error('Invalid name of day');
				break;
		}
	};

	eventCalendar.prototype.getNameOfDay = function(dayNum, monthNum, yearNum) {
		let dateStr = yearNum + '-' + (monthNum + 1) + '-' + dayNum;
		let dateNameAbbr = new Date(dateStr).toString().split(' ')[0];
		switch (dateNameAbbr) {
			case 'Mon':
				return this.checkNameOfDayDiffLang(0);
			case 'Tue':
				return this.checkNameOfDayDiffLang(1);
			case 'Wed':
				return this.checkNameOfDayDiffLang(2);
			case 'Thu':
				return this.checkNameOfDayDiffLang(3);
			case 'Fri':
				return this.checkNameOfDayDiffLang(4);
			case 'Sat':
				return this.checkNameOfDayDiffLang(5);
			case 'Sun':
				return this.checkNameOfDayDiffLang(6);
		}
	};

	eventCalendar.prototype.initializeCalendar = function() {
		that.currentMonthNum = this.setCurrentMonthNum(new Date());
		that.currentMontName = this.setCurrentMonthName(that.currentMonthNum);
		that.currentYear = this.setCurrentYear(new Date());
		that.firstDayOfMonth = this.setFirstDayOfMonth(that.currentYear, that.currentMonthNum);
		that.indexToStartDays = this.setindexToStartDays(that.firstDayOfMonth);
		that.currentMontCountOfDays = this.setCurrentMontCountOfDays(that.currentYear, that.currentMonthNum + 1);
		that.todayNum = this.setTodayNum(new Date());
		let tableStr = '';

		switch (that.language) {
			case 'en':
				tableStr = `<table class="centered" id="evCalendar">
				<thead>
				<tr>
					<th colspan="7" class="center-align">
					 <a href="#" id="prevMont">&lt;</a>
					 <span id="monthLabel">${that.currentMontName}</span>
					 <a href="#" id="nextMont">&gt;</a>
					</th>
				</tr>
				<tr>
				<th colspan="7" class="center-align">
				 <a href="#" id="prevYear">&lt;</a>
				 <span id="yearLabel">${that.currentYear}</span>
				 <a href="#" id="nextYear">&gt;</a>
				</th>
			</tr>
				<tr>
					<th>Mon</th>
					<th>Tue</th>
					<th>Wed</th>
					<th>Thu</th>
					<th>Fri</th>
					<th>Sat</th>
					<th>Sun</th>
				</tr>
				</thead>
				<tbody id="evCalendarBody">
				</tbody>
			</table>`;
				break;
			case 'bg':
				tableStr = `<table class="centered" id="evCalendar">
					<thead>
                    <tr>
                        <th colspan="7" class="center-align">
                         <a href="#" id="prevMont">&lt;</a>
						 <span id="monthLabel">${that.currentMontName}</span>
						 <a href="#" id="nextMont">&gt;</a>
                        </th>
					</tr>
					<tr>
					<th colspan="7" class="center-align">
					 <a href="#" id="prevYear">&lt;</a>
					 <span id="yearLabel">${that.currentYear}</span>
					 <a href="#" id="nextYear">&gt;</a>
					</th>
				</tr>
                    <tr>
                        <th>Пон</th>
                        <th>Вто</th>
                        <th>Сря</th>
                        <th>Чет</th>
                        <th>Пет</th>
                        <th>Съб</th>
                        <th>Нед</th>
					</tr>
					</thead>
                    <tbody id="evCalendarBody">
                    </tbody>
                </table>`;
				break;
			default:
				tableStr = `<table class="centered" id="evCalendar">
				<thead>
				<tr>
					<th colspan="7" class="center-align">
					 <a href="#" id="prevMont">&lt;</a>
					 <span id="monthLabel">${that.currentMontName}</span>
					 <a href="#" id="nextMont">&gt;</a>
					</th>
				</tr>
				<tr>
				<th colspan="7" class="center-align">
				 <a href="#" id="prevYear">&lt;</a>
				 <span id="yearLabel">${that.currentYear}</span>
				 <a href="#" id="nextYear">&gt;</a>
				</th>
			</tr>
				<tr>
					<th>Mon</th>
					<th>Tue</th>
					<th>Wed</th>
					<th>Thu</th>
					<th>Fri</th>
					<th>Sat</th>
					<th>Sun</th>
				</tr>
				</thead>
				<tbody id="evCalendarBody">
				</tbody>
			</table>`;
				break;
		}

		return tableStr;
	};

	eventCalendar.prototype.getMonthRows = function(cellsCount) {
		let rows = Math.ceil(cellsCount / 7);
		let date = new Date(that.currentYear, that.currentMonthNum + 1, 0).toString();
		let latestMonthDayName = date.split(' ')[0];

		switch (latestMonthDayName) {
			case 'Sun':
				return rows - 1;
				break;
			case 'Mon':
				return rows;
				break;
			case 'Tue':
				return rows;
				break;
			case 'Wed':
				return rows;
				break;
			case 'Thu':
				return rows;
				break;
			case 'Fri':
				return rows;
				break;
			case 'Sat':
				return rows - 1;
				break;
			default:
				return rows;
				break;
		}
	};

	eventCalendar.prototype.createLocalEvent = function() {
		let hoursBegin = document.getElementsByName('hoursBegin')[0].value;
		let hoursFinish = document.getElementsByName('hoursFinish')[0].value;
		let eventTextName = document.getElementsByName('eventTextName')[0].value;
		let day = parseInt(document.getElementById('mainDateLabel').innerText);
		day = day < 10 ? '0' + day : day;
		let month = that.currentMonthNum + 1;
		let year = that.currentYear;
		month = month < 10 ? '0' + month : month;
		let date = year + '-' + month + '-' + day;
		let eventObj = {
			id: that.eventsData.length + 1,
			date: date,
			from: hoursBegin,
			to: hoursFinish,
			text: eventTextName
		};
		that.eventsData.push(eventObj);
		this.closeEventWindow();
		this.drawCalendarBody();
		// {id: 11, date: '2020-02-16', from: '00:00:00', to: '18:00:00', text: 'Work meeting'},
	};

	eventCalendar.prototype.getIndexOfSearchedEvent = function(prop, keyword, data) {
		let index = -1;
		for (let i = 0; i < data.length; i++) {
			if (data[i][prop] === keyword) {
				index = i;
			}
		}

		return index;
	};

	eventCalendar.prototype.editingLocalEvent = function() {
		let hoursBegin = document.getElementsByName('hoursBegin')[0].value;
		let hoursFinish = document.getElementsByName('hoursFinish')[0].value;
		let eventTextName = document.getElementsByName('eventTextName')[0].value;
		let day = parseInt(document.getElementById('mainDateLabel').innerText);
		let editedDate = document.getElementsByName('editedDate')[0].value;
		day = day < 10 ? '0' + day : day;
		let month = that.currentMonthNum + 1;
		let year = that.currentYear;
		month = month < 10 ? '0' + month : month;
		let date = year + '-' + month + '-' + day;

		// let eventIndex = that.eventsData.filter((event, index) => {
		// 	if(event.date === date) return index;
		// });
		let eventIndex = this.getIndexOfSearchedEvent('date', date, that.eventsData);
		if (eventIndex < 0) {
			alert('No event found.There must be some error');
			throw new Error('No such event found');
			return;
		}

		let event = that.eventsData[eventIndex];
		event.date = editedDate;
		event.from = hoursBegin;
		event.to = hoursFinish;
		event.text = eventTextName;
		// for(let i = 0; i < that.eventsData.length; i++){
		// 	if(that.eventsData[i].date === date){
		// 		eventIndex = i;
		// 	}
		// }

		// console.log(that.eventsData[eventIndex]);

		// return;
		// let eventObj = {id: that.eventsData.length + 1, date: date, from: hoursBegin, to: hoursFinish, text: eventTextName};
		// that.eventsData.push(eventObj);
		this.closeEventWindow();
		this.drawCalendarBody();
	};

	eventCalendar.prototype.getTranslatedWord = function(word, from, to) {
		let indexOfSearchWordInCurrLang = -1;
		let indexEnArr = 0;
		let indexBgArr = 0;

		switch (from) {
			case 'en':
				for (let arr of allEnLabels) {
					indexOfSearchWordInCurrLang = arr.indexOf(word);
					if (indexOfSearchWordInCurrLang != -1) {
						break;
					}
					indexEnArr++;
				}

				if (indexOfSearchWordInCurrLang < 0) {
					return word;
				}

				switch (to) {
					case 'en':
						return word;
					case 'bg':
						return that.allBgLabels[indexEnArr][indexOfSearchWordInCurrLang];
				}

				break;
			case 'bg':
				for (let arr of allBgLabels) {
					indexOfSearchWordInCurrLang = arr.indexOf(word);
					if (indexOfSearchWordInCurrLang != -1) {
						break;
					}
					indexBgArr++;
				}

				if (indexOfSearchWordInCurrLang < 0) {
					return word;
				}

				switch (to) {
					case 'bg':
						return word;
					case 'en':
						return that.allEnLabels[indexBgArr][indexOfSearchWordInCurrLang];
				}

				break;
		}
	};

	eventCalendar.prototype.addEventForm = function() {
		// console.log(this.getTranslatedWord('Редактирай', 'en', 'bg'));
		// alert(document.getElementById('mainDateLabel').innerText);
		let createEvenBtnTxt, clearBtnTx, beginLabelTx, finishLabelTx, textLabelTx;

		switch (that.language) {
			case 'en':
				createEvenBtnTxt = that.buttonLabelsEn[0];
				clearBtnTx = that.buttonLabelsEn[8];
				beginLabelTx = that.eventsLabelsEn[3];
				finishLabelTx = that.eventsLabelsEn[4];
				textLabelTx = that.eventsLabelsEn[5];
				break;
			case 'bg':
				createEvenBtnTxt = this.getTranslatedWord(that.buttonLabelsEn[0], 'en', 'bg');
				clearBtnTx = this.getTranslatedWord(that.buttonLabelsEn[8], 'en', 'bg');
				beginLabelTx = this.getTranslatedWord(that.eventsLabelsEn[3], 'en', 'bg');
				finishLabelTx = this.getTranslatedWord(that.eventsLabelsEn[4], 'en', 'bg');
				textLabelTx = this.getTranslatedWord(that.eventsLabelsEn[5], 'en', 'bg');
				break;
			default:
				createEvenBtnTxt = that.buttonLabelsEn[0];
				clearBtnTx = that.buttonLabelsEn[8];
				beginLabelTx = that.eventsLabelsEn[3];
				finishLabelTx = that.eventsLabelsEn[4];
				textLabelTx = that.eventsLabelsEn[5];
				break;
		}

		let eventsDashboard = document.getElementById('eventsDashboard');
		eventsDashboard.innerHTML = '<div id="addEventCont"></div>';
		let form = `
			<form id="createEventForm" action="/evCalendar/events/addDate/${that.currentlySelectedDay}" method="post">
				<label for="eventText">${textLabelTx}</label>
				<textarea id="eventText" name="eventText" class="materialize-textarea"></textarea>
				<label for="hoursBegin">${beginLabelTx}</label>
				  <input type="text" name="hoursBegin" class="timepicker" />
				  <label for="hoursFinish">${finishLabelTx}</label>
				  <input type="text" name="hoursFinish" class="timepicker" />  
				  <input type="hidden" name="selectedMonth" value="${++that.currentMonthNum}" />
				  <input type="hidden" name="selectedYear" value="${that.currentYear}" />
				  <input type="submit" class="waves-effect waves-light btn" value="${createEvenBtnTxt}" />
				  <input type="reset" class="waves-effect waves-light btn" value="${clearBtnTx}" />
				  </form>
				  `;
		// <a id="createLocalEvent" href="#" class="waves-effect waves-light btn">${createEvenBtnTxt}</a>
		//   <input type="submit" class="waves-effect waves-light btn" value="Create Event" />

		eventsDashboard.innerHTML += form;

		// let createLocalEventBtn = document.getElementById('createLocalEvent');
		// createLocalEventBtn.addEventListener('click', () => this.createLocalEvent());

		let elems = document.querySelectorAll('.timepicker');
		let instances = M.Timepicker.init(elems, { twelveHour: false, showClearBtn: true });
	};

	eventCalendar.prototype.editLocalEvent = function(event) {
		let eventsDashboard = document.getElementById('eventsDashboard');
		eventsDashboard.innerHTML = '<div id="addEventCont"></div>';
		let editStaticEvenBtnTx = '';
		let clearBtnTx = '';
		let dateLabelTx = '';
		let beginLabelTx = '';
		let finishLabelTx = '';
		let textLabelTx = '';
		let checkedEventLbl = '';

		switch (that.language) {
			case 'en':
				editStaticEvenBtnTx = that.buttonLabelsEn[1];
				clearBtnTx = that.buttonLabelsEn[8];
				dateLabelTx = that.eventsLabelsEn[6];
				beginLabelTx = that.eventsLabelsEn[3];
				finishLabelTx = that.eventsLabelsEn[4];
				textLabelTx = that.eventsLabelsEn[5];
				checkedEventLbl = that.eventsLabelsEn[9];
				break;
			case 'bg':
				editStaticEvenBtnTx = this.getTranslatedWord(that.buttonLabelsEn[1], 'en', 'bg');
				clearBtnTx = this.getTranslatedWord(that.buttonLabelsEn[8], 'en', 'bg');
				dateLabelTx = this.getTranslatedWord(that.eventsLabelsEn[6], 'en', 'bg');
				beginLabelTx = this.getTranslatedWord(that.eventsLabelsEn[3], 'en', 'bg');
				finishLabelTx = this.getTranslatedWord(that.eventsLabelsEn[4], 'en', 'bg');
				textLabelTx = this.getTranslatedWord(that.eventsLabelsEn[5], 'en', 'bg');
				checkedEventLbl = this.getTranslatedWord(that.eventsLabelsEn[9], 'en', 'bg');
				break;
			default:
				editStaticEvenBtnTx = that.buttonLabelsEn[1];
				clearBtnTx = that.buttonLabelsEn[8];
				dateLabelTx = that.eventsLabelsEn[6];
				beginLabelTx = that.eventsLabelsEn[3];
				finishLabelTx = that.eventsLabelsEn[4];
				textLabelTx = that.eventsLabelsEn[5];
				checkedEventLbl = that.eventsLabelsEn[9];
				break;
		}

		let form = `
			<form id="editEventForm" action="/evCalendar/events/editEvent/${event.id}" method="post">
			<label for="eventText">${textLabelTx}</label>
			<textarea id="eventText" name="eventTextName" class="materialize-textarea">${event.text}</textarea>
			<label for="editDate">${dateLabelTx}</label>
			<input type="text" name="editedDate" class="datepicker" value="${event.date}" />
				<label for="hoursBegin">${beginLabelTx}</label>
				  <input type="text" name="hoursBegin" value="${event.from}" class="timepicker" />
				  <label for="hoursFinish">${finishLabelTx}</label>
				  <input type="text" name="hoursFinish" value="${event.to}" class="timepicker" />

				  <label>
					  <input type="checkbox" name="checkedEvent" value="Checked" ${!event.checked ? '' : 'checked'} />
					  <span>${checkedEventLbl}</span>
				  </label>
				 
				  <input type="hidden" name="eventAuthor" value="${event.user_id}" />
				  <input type="submit" class="waves-effect waves-light btn" value="Edit Event" />
				  <input type="reset" class="waves-effect waves-light btn" value="${clearBtnTx}" />
				  </form>
				  `;
		//   <a id="editLocalEvent" href="#" class="waves-effect waves-light btn">${editStaticEvenBtnTx}</a>

		eventsDashboard.innerHTML += form;

		// let editLocalEventBtn = document.getElementById('editLocalEvent');
		// editLocalEventBtn.addEventListener('click', () => this.editingLocalEvent());

		let elems = document.querySelectorAll('.timepicker');
		let datePickElems = document.querySelectorAll('.datepicker');
		let instances = M.Timepicker.init(elems, { twelveHour: false, showClearBtn: true });
		let dateInstances = M.Datepicker.init(datePickElems, { format: 'yyyy-mm-dd', showClearBtn: true });
	};

	eventCalendar.prototype.deleteLocalEvent = function(event) {
		let eventIndex = this.getIndexOfSearchedEvent('id', event.id, that.eventsData);
		if (eventIndex < 0) {
			alert('No event found.There must be some error');
			console.log('No such event found');
			// throw new Error('No such event found');
			return;
		}

		let confirmDelete = confirm(`Are you sure to delete event from ${event.date} and text ${event.text}?`);
		if (confirmDelete) {
			that.eventsData.splice(eventIndex, 1);
			window.location = `/evCalendar/events/deleteEvent/?eventId=${event.id}&author=${event.user_id}`;
		}

		this.closeEventWindow();
		this.drawCalendarBody();
		// console.log(eventIndex);
	};

	eventCalendar.prototype.checkUncheckLocalEvent = function(event) {
		event.checked = !event.checked;
		let day = event.date.split('-')[2];
		this.closeEventWindow();
		this.showDate(day);
		this.showEventItems();
		window.location = `/evCalendar/events/checkUncheckEvent/?eventId=${event.id}&author=${event.user_id}&checked=${event.checked}`;
	};

	eventCalendar.prototype.reverseDateString = function(dateStr){
		return dateStr.split('-').reverse().join('-');
	}

	eventCalendar.prototype.createList = function(type, data, addButtons) {
		let listCont = document.createElement(type);
		listCont.setAttribute('id', 'eventsCont');
		li = null;

		for (let event of data) {
			li = document.createElement('li');
			li.innerText = `${this.reverseDateString(event.date)} - ${event.from} : ${event.to} - ${event.text}`;

			if (event.checked) {
				li.setAttribute('class', 'itemChecked');
			}

			if (addButtons) {
				let editBtn = document.createElement('a');
				let deleteBtn = document.createElement('a');
				let checkUncheckBtn = document.createElement('a');
				editBtn.setAttribute('class', 'waves-effect waves-light btn addButtons');
				// editBtn.setAttribute('href', `/editEvent/${event.id}`);
				editBtn.setAttribute('href', `#`);
				switch (that.language) {
					case 'en':
						editBtn.innerText = that.buttonLabelsEn[1];
						deleteBtn.innerText = that.buttonLabelsEn[2];
						checkUncheckBtn.innerText = that.buttonLabelsEn[3];
						break;
					case 'bg':
						editBtn.innerText = that.buttonLabelsBg[1];
						deleteBtn.innerText = that.buttonLabelsBg[2];
						checkUncheckBtn.innerText = that.buttonLabelsBg[3];
						break;
					default:
						editBtn.innerText = that.buttonLabelsEn[1];
						deleteBtn.innerText = that.buttonLabelsEn[2];
						checkUncheckBtn.innerText = that.buttonLabelsEn[3];
						break;
				}
				editBtn.onclick = () => this.editLocalEvent(event);
				deleteBtn.setAttribute('class', 'waves-effect red accent-4 btn addButtons');
				// deleteBtn.setAttribute('href', `/deleteEvent/${event.id}`);
				deleteBtn.onclick = () => this.deleteLocalEvent(event);
				// deleteBtn.innerText = 'Delete';
				checkUncheckBtn.setAttribute('class', 'waves-effect waves-light btn addButtons');
				// editBtn.setAttribute('href', `/editEvent/${event.id}`);
				checkUncheckBtn.setAttribute('href', `#`);
				// checkUncheckBtn.innerText = 'Check/Uncheck';
				checkUncheckBtn.onclick = () => this.checkUncheckLocalEvent(event);

				li.appendChild(checkUncheckBtn);
				li.appendChild(editBtn);
				li.appendChild(deleteBtn);
			}
			listCont.appendChild(li);
		}

		return listCont;
	};

	eventCalendar.prototype.generateList = function(type, data, listId, addButtons) {
		if (!data || data.length === 0) {
			// throw new Error('Problem with data. Invalid or no content. You must pass an array with objects');
			let list = type == 'ul' ? document.createElement('ul') : document.createElement('ol');
			list.setAttribute('id', listId);
			let li = document.createElement('li');

			switch (that.language) {
				case 'en':
					li.innerText = that.eventsLabelsEn[2];
					break;
				case 'bg':
					li.innerText = that.eventsLabelsBg[2];
					break;
				default:
					li.innerText = that.eventsLabelsEn[2];
					break;
			}
			// li.innerText = 'No events';
			list.appendChild(li);
			return list;
		}

		let listCont = null;

		switch (type) {
			case 'ul':
				listCont = this.createList('ul', data, addButtons);
				return listCont;
				break;
			case 'ol':
				(listCont = this.createList('ol', data)), addButtons;
				break;
			default:
				listCont = this.createList('ul', data);
				return listCont;
				break;
		}
	};

	eventCalendar.prototype.drawEvents = function(eventsDataList, container) {
		if (document.getElementById('eventsList')) {
			document.getElementById('eventsList').remove();
		}
		let listCont = document.createElement('div');
		listCont.setAttribute('id', 'eventsList');
		listCont.setAttribute('class', 'flow-text');
		// listCont.style.overflow = 'scroll';
		listCont.appendChild(eventsDataList);

		if (document.getElementById('eventsCont')) {
			document.getElementById('eventsCont').innerHTML = '';
		}
		container.appendChild(listCont);
	};

	eventCalendar.prototype.showLessEvents = function() {
		let eventsListDiv = document.getElementById('eventsList');
		let eventsDashboarCont = document.getElementById('eventsDashboard');
		eventsListDiv.innerHTML = '';

		that.eventsPagStartIndex = that.eventsPagIndex;
		// that.eventsPagIndex -= (that.eventsPageSize * 2);

		if (that.eventsPagIndex > 0) {
			that.eventsPagIndex -= that.eventsPageSize;
		}
		// console.log(that.eventsPagStartIndex);

		// console.log(that.eventsResult);
		let res = that.eventsResult.slice();
		res = res.slice(that.eventsPagIndex, that.eventsPagStartIndex);
		if (res.length === 0) {
			return;
		}
		// console.log(that.eventsResult);

		//Here to redraw list with next events
		let list = this.generateList('ul', res, 'eventsCont', true);
		this.drawEvents(list, eventsDashboarCont);
	};

	eventCalendar.prototype.showMoreEvents = function() {
		let eventsListDiv = document.getElementById('eventsList');
		let eventsDashboarCont = document.getElementById('eventsDashboard');
		eventsListDiv.innerHTML = '';

		let res = that.eventsResult.slice();
		that.eventsPagStartIndex = that.eventsPagIndex;

		if (that.eventsPagIndex < res.length * that.eventsPageSize) {
			that.eventsPagIndex += that.eventsPageSize;
		}
		// console.log(that.eventsPagStartIndex);
		// console.log(that.eventsPagIndex);

		res = res.slice(that.eventsPagStartIndex, that.eventsPagIndex);
		// console.log(that.eventsResult);
		if (res.length === 0) {
			return;
		}
		// console.log(that.eventsResult);

		//Here to redraw list with next events
		let list = this.generateList('ul', res, 'eventsCont', true);
		this.drawEvents(list, eventsDashboarCont);
	};

	eventCalendar.prototype.showEventItems = function() {
		let eventsDashboarCont = document.getElementById('eventsDashboard');
		eventsDashboarCont.innerHTML = '';
		let dayNum = !parseInt(document.getElementById('mainDateLabel').innerText)
			? that.currentlySelectedDay
			: parseInt(document.getElementById('mainDateLabel').innerText);
		dayNum = dayNum < 10 ? '0' + dayNum : dayNum;
		let month = that.currentMonthNum + 1;
		month = month < 10 ? '0' + month : month;
		let searchedDate = that.currentYear + '-' + month + '-' + dayNum;
		that.eventsResult = that.eventsData.filter((x) => x.date === searchedDate);
		// console.log(that.eventsResult);
		let res = that.eventsResult.slice();

		if (that.eventsResult.length > 5) {
			res = res.slice(that.eventsPagStartIndex, that.eventsPagIndex);
			let nextPageBtn = document.createElement('a');
			nextPageBtn.setAttribute('class', 'waves-effect waves-light btn');
			switch (that.language) {
				case 'en':
					nextPageBtn.innerText = that.buttonLabelsEn[5];
					break;
				case 'bg':
					nextPageBtn.innerText = that.buttonLabelsEn[5];
					break;
				default:
					nextPageBtn.innerText = that.buttonLabelsEn[5];
					break;
			}
			// nextPageBtn.innerText = 'Show More';
			nextPageBtn.onclick = () => this.showMoreEvents();
			eventsDashboarCont.appendChild(nextPageBtn);

			let showPrevEventsBtn = document.createElement('a');
			showPrevEventsBtn.setAttribute('class', 'waves-effect waves-light btn');
			switch (that.language) {
				case 'en':
					showPrevEventsBtn.innerText = that.buttonLabelsEn[6];
					break;
				case 'bg':
					showPrevEventsBtn.innerText = that.buttonLabelsEn[6];
					break;
				default:
					showPrevEventsBtn.innerText = that.buttonLabelsEn[6];
					break;
			}
			// showPrevEventsBtn.innerText = 'Show Previous';
			showPrevEventsBtn.onclick = () => this.showLessEvents();
			eventsDashboarCont.appendChild(showPrevEventsBtn);
		}

		let list = this.generateList('ul', res, 'eventsCont', true);
		this.drawEvents(list, eventsDashboarCont);
		// eventsDashboarCont.appendChild(list);
	};

	eventCalendar.prototype.clearContainerById = function(id) {
		if (document.getElementById(id)) {
			document.getElementById(id).innerHTML = '';
		}
	};

	eventCalendar.prototype.closeEventWindow = function() {
		if (document.getElementById('eventsContainer')) {
			// document.getElementById('eventsContainer').innerHTML = '';
			document.getElementById('eventsContainer').classList.remove('visible');
			document.getElementById('eventsContainer').setAttribute('class', 'nonVisible');
			// document.getElementById('eventsContainer').style.visibility = 'hidden';
			// document.getElementById('eventsContainer').remove();
			that.eventWindowToggled = false;
			this.clearContainerById('addEventCont');
			this.clearContainerById('eventsDashboard');
			this.checkRecentlyPastEvents();
		}
	};

	eventCalendar.prototype.showDate = function(day) {
		that.eventWindowToggled = !that.eventWindowToggled;
		if (that.eventWindowToggled) {
			if (!day) {
				return;
			}

			if (document.getElementById('eventsSection')) {
				this.clearContainerById('eventsSection');
			}

			that.currentlySelectedDay = day;
			let dayNum = parseInt(day) < 10 ? '0' + parseInt(day) : day;
			let nameOfDay = this.getNameOfDay(dayNum, that.currentMonthNum, that.currentYear);
			let addEventBtn = document.createElement('a');
			let showEventItemsBtn = document.createElement('a');
			addEventBtn.setAttribute('class', 'waves-effect waves-light btn');

			switch (that.language) {
				case 'en':
					addEventBtn.innerText = that.buttonLabelsEn[0];
					showEventItemsBtn.innerText = that.buttonLabelsEn[4];
					break;
				case 'bg':
					addEventBtn.innerText = that.buttonLabelsBg[0];
					showEventItemsBtn.innerText = that.buttonLabelsBg[4];
					break;
				default:
					addEventBtn.innerText = that.buttonLabelsEn[0];
					showEventItemsBtn.innerText = that.buttonLabelsEn[4];
					break;
			}
			addEventBtn.onclick = () => this.addEventForm();

			showEventItemsBtn.setAttribute('class', 'waves-effect waves-light btn eventBtns');
			showEventItemsBtn.onclick = () => this.showEventItems();
			if (!document.getElementById('addEventCont')) {
				let addEventContDiv = document.createElement('div');
				addEventContDiv.setAttribute('id', 'addEventCont');
				document.getElementById('eventsDashboard').appendChild(addEventContDiv);
			}
			let closeWindowBtn = document.createElement('a');
			closeWindowBtn.setAttribute('class', 'waves-effect waves-light btn');
			closeWindowBtn.innerText = 'X';
			closeWindowBtn.onclick = () => this.closeEventWindow();
			// document.getElementById('addEventCont').innerHTML = '';
			this.clearContainerById('addEventCont');
			document.getElementById('addEventCont').appendChild(addEventBtn);
			if (this.checkDayForEvents(dayNum)) {
				document.getElementById('addEventCont').appendChild(showEventItemsBtn);
			}
			// document.getElementById('closeWindowBtnCont').innerHTML = '';
			this.clearContainerById('closeWindowBtnCont');
			document.getElementById('closeWindowBtnCont').appendChild(closeWindowBtn);
			document.getElementById('mainDateLabel').innerText = parseInt(day);
			document.getElementById('dayName').innerText = nameOfDay;
			document.getElementById('yearField').innerText = document.getElementById('yearLabel').innerText;
			document.getElementById('nameOfMonth').innerText = document.getElementById('monthLabel').innerText;
			document.getElementById('eventsContainer').classList.remove('nonVisible');
			document.getElementById('eventsContainer').setAttribute('class', `visible ${that.mainTheme}`);

			// document.getElementById('eventsContainer').style.visibility = 'visible';
		} else {
			this.closeShowDateWindow();
		}
	};

	eventCalendar.prototype.closeShowDateWindow = function() {
		this.clearContainerById('addEventCont');
		this.clearContainerById('eventsDashboard');
		document.getElementById('eventsContainer').classList.remove('visible');
		document.getElementById('eventsContainer').setAttribute('class', 'nonVisible');
		this.checkRecentlyPastEvents();
	};

	eventCalendar.prototype.checkDayForEvents = function(day) {
		if (!that.eventsData || that.eventsData.length === 0) {
			return;
		}

		let month = that.currentMonthNum + 1 < 10 ? '0' + (that.currentMonthNum + 1) : that.currentMonthNum + 1;
		let currentDay = parseInt(day) < 10 ? '0' + parseInt(day) : day;
		let searchedDate = that.currentYear + '-' + month + '-' + currentDay;
		let result = that.eventsData.filter((event) => event.date === searchedDate);
		return result.length > 0;
	};

	eventCalendar.prototype.drawCalendarBody = function() {
		// let tbodyRowsForRem = document.getElementsByTagName('tbody');
		if (that.calendarBody != null) {
			that.calendarTable.removeChild(that.calendarBody);
			that.calendarBody = document.createElement('tbody', 'evCalendarBody');
			that.calendarBody.setAttribute('id', 'evCalendarBody');
			that.calendarTable.appendChild(that.calendarBody);
		}

		// console.log(rows);
		// console.log(rows.parentNode);

		that.calendarBody.innerHTML = '<tr></tr>';
		let cellsCount = that.currentMontCountOfDays;
		// console.log(that.currentMontCountOfDays);
		// let tableRowsCount = Math.ceil(cellsCount / 7);
		let tableRowsCount = this.getMonthRows(cellsCount);
		let dayNum = 1;
		let counter = 0;

		for (let row = 0; row <= tableRowsCount; row++) {
			let tr = document.createElement('tr');
			for (let day = 0; day < 7; day++) {
				let td = document.createElement('td');

				//check if the index is in indexToStartDays. If it is then the cell must be empty
				if (day + counter < that.indexToStartDays || dayNum > that.currentMontCountOfDays) {
					if ((day == 5 || day == 6) && td.innerText != '') {
						let num = dayNum;
						td.setAttribute('class', '#1e88e5 blue light-1');
						td.setAttribute('id', `day${dayNum}`);
						td.onclick = () => this.showDate(num);
					}
					tr.append(td);
				} else {
					//if it is NOT in indexToStartDays then write day number in cell.

					td.innerText = dayNum;
					if (this.checkDayForEvents(dayNum)) {
						let eventSpanSymbol = document.createElement('span');
						eventSpanSymbol.setAttribute('class', 'eventDot');
						// eventSpanSymbol.style.background = 'green';
						// eventSpanSymbol.style.height = '10px';
						// eventSpanSymbol.style.width = '10px';
						// eventSpanSymbol.style.borderRadius = '50%';
						td.appendChild(eventSpanSymbol);
					}
					let num = dayNum;
					td.setAttribute('id', `day${dayNum}`);
					td.onclick = () => this.showDate(num);
					if (dayNum == that.todayNum) {
						td.setAttribute('class', '#1e88e5 blue light-1');
						td.onclick = () => this.showDate(num);
					}

					if ((day == 5 || day == 6) && td.innerText != '') {
						td.setAttribute('class', '#1e88e5 blue light-1');
						td.setAttribute('id', `day${dayNum}`);
						td.onclick = () => this.showDate(num);
					}
					tr.append(td);
					dayNum++;
				}
			}
			counter += 7;
			that.calendarBody.append(tr);
		}

		// for(let i = 0; i < cellsCount; i++){
		//     let td = document.createElement('td');

		//     //drawing empty cells
		//     if(i < that.indexToStartDays){

		//         firstRow.appendChild(td);

		//         // let td = document.createElement('td');
		//         // that.calendarBody.appendChild(td);
		//     } else {
		//         if(i % 7 == 0){ //check for the end of the line and if is then put new row
		//             newTr = document.createElement('tr');
		//             that.calendarBody.appendChild(newTr);
		//             // that.calendarBody.insertRow();
		//             // let tr = document.createElement('tr');
		//             // that.calendarBody.appendChild(tr);
		//         }

		//         if(newTr){}
		//         td.setAttribute('class', `center-align`);
		//         td.innerText = dayNum;
		//         firstRow.appendChild(td);

		//         // td.setAttribute('class', `center-align`);
		//         // td.innerText = dayNum;
		//         // that.calendarBody.appendChild(td);

		//         // html += `<td class="center-align">${dayNum}</td>`;
		//         // td = document.createElement('td');
		//         dayNum++;
		//     }

		// }
	};

	eventCalendar.prototype.addListenersToCalendar = function() {
		let prevMonthBtn = document.getElementById('prevMont');
		prevMonthBtn.addEventListener('click', () => this.prevMonth());

		let nextMonthBtn = document.getElementById('nextMont');
		nextMonthBtn.addEventListener('click', () => this.nextMonth());

		let prevYearBtn = document.getElementById('prevYear');
		prevYearBtn.addEventListener('click', () => this.prevYear());

		let nextYearBtn = document.getElementById('nextYear');
		nextYearBtn.addEventListener('click', () => this.nextYear());
	};

	eventCalendar.prototype.genLastWeekDateStr = function() {
		let today = new Date();
		let lastWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 7);
		let lastWeekDay = lastWeek.getDate();
		let lastWeekMonth = lastWeek.getMonth() + 1;
		let lastWeekYear = lastWeek.getFullYear();

		lastWeekDay = lastWeekDay < 10 ? '0' + lastWeekDay : lastWeekDay;
		lastWeekMonth = lastWeekMonth < 10 ? '0' + lastWeekMonth : lastWeekMonth;
		let generatedLastWeekDate = lastWeekYear + '-' + lastWeekMonth + '-' + lastWeekDay;

		return generatedLastWeekDate;
	};

	eventCalendar.prototype.genCurrentWeekDateStr = function() {
		let today = new Date();
		let currentWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate());
		let currentWeekDay = currentWeek.getDate();
		let currentWeekMonth = currentWeek.getMonth() + 1;
		let currentWeekYear = currentWeek.getFullYear();

		currentWeekDay = currentWeekDay < 10 ? '0' + currentWeekDay : currentWeekDay;
		currentWeekMonth = currentWeekMonth < 10 ? '0' + currentWeekMonth : currentWeekMonth;
		let generatedCurrentWeekDate = currentWeekYear + '-' + currentWeekMonth + '-' + currentWeekDay;

		return generatedCurrentWeekDate;
	};

	//Return object with key date-month and value true for all values of the given arr
	//Purpose is to search for these dates later and to save time.
	eventCalendar.prototype.createAvailableDateMonthObj = function(arr){
		let obj = {};
		let dateArr;
		let dateStr = '';
		if(!arr || arr.length === 0) return obj;
		for(let day of arr){
			if(day){
				dateArr = day.split('-');
				dateStr += dateArr[2] + '-' + dateArr[1];
				obj[dateStr] = true;
				dateStr = '';
			}
		}

		return obj;
	}

	//add new prop dateMonth to objects in given array  and return new array with mofidied objects 
	eventCalendar.prototype.getArrDateMonthFromObj = function(arrWithObjs){
		let resultArr = [];
		let dateStr = '';
		let dateArr = [];
		if(arrWithObjs.length === 0) return resultArr;
		
		for(let event of arrWithObjs){
			// console.log(event);
			if(!event.date || event.date == "") continue;
			dateArr = event.date.split('-');
			dateStr += dateArr[2] + '-' + dateArr[1];
			event.dateMonth = dateStr;
			resultArr.push(event);
			dateStr = '';
		}
		
		return resultArr;
	}

	eventCalendar.prototype.extractEvents = function(daysToCheck) {
		if (!that.eventsData) return [];
		// console.log(daysToCheck);
		// console.log(this.createAvailableDateMonthObj(daysToCheck));
		let daysToCheckObj = this.createAvailableDateMonthObj(daysToCheck);
		let eventsDatesArr= this.getArrDateMonthFromObj(that.eventsData);
		
		// console.log(daysToCheckObj);
		let result = [];
		
		for(let event of eventsDatesArr){
			if(daysToCheckObj[event.dateMonth]){
				result.push(event);
			}
		}
		// let eventDateArr;
		// let checkingDateArr;
		
		// for (let day of daysToCheck) {
		// 	for (let evDate of that.eventsData) {
		// 		eventDateArr = evDate.date.split('-');
		// 		checkingDateArr = day.split('-');
		// 		//check day and month if are equals
		// 		if (checkingDateArr[2] === eventDateArr[2] && checkingDateArr[1] === eventDateArr[1]) {
		// 			result.push(evDate);
		// 		}
		// 	}
		// }

		// console.log(result.length);
		return this.sortDataEventsByDate(result);
	};

	eventCalendar.prototype.formattedDate = function(date) {
		let dd = date.getDate();
		let mm = date.getMonth() + 1;
		let yyyy = date.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		// date = mm + '/' + dd + '/' + yyyy;
		date = yyyy + '-' + mm + '-' + dd;
		return date;
	};

	eventCalendar.prototype.getStrDatesFromCount = function(type, daysCount) {
		let res = [];
		let currentMontDays = new Date(that.currentYear, that.currentMonthNum + 1, 0).getDate();
		let prevMonthDays = new Date(that.currentYear, that.currentMonthNum, 0).getDate();
		let month = that.currentMonthNum;
		let date = new Date().getDate();
	
		//months - from 0 to 11
		switch (type) {
			case 'prev':
				for (let i = 0; i < daysCount; i++) {
					let d = new Date();
					// let dd = d.getDate() - i;
					// d.setDate(dd);

					if (date < 1) {
						date = prevMonthDays;
						month--;
						d.setMonth(month);
						d.setDate(date);
					} else {
						d.setDate(date);
						d.setMonth(month);
					}
					date--;
					// d.setDate(d.getDate() - i);
					// d.setMonth(month);
					// console.log(this.formattedDate(d));
					res.push(this.formattedDate(d));
				}
				break;
			case 'next':
					date++;
				for (let i = 0; i < daysCount; i++) {
					let d = new Date();
					// let dd = d.getDate() + i > currentMontDays ? 1 : d.getDate() + i;
					// console.log(dd);
					// d.setDate(dd);
					if (date > currentMontDays) {
						date = 1;
						d.setDate(date);
						d.setMonth(++month);
					} else {
						d.setDate(date);
						d.setMonth(month);
					}
					date++;
					// d.setMonth(that.currentMonthNum);
					res.push(this.formattedDate(d));
				}
				
				break;
		}
		
		return res;
	};

	eventCalendar.prototype.getCurrentDayEvents = function() {
		let today = new Date().getDate();
		let day;

		if (!that.eventsData) return [];

		let result = [];

		for (let dateEvent of that.eventsData) {
			day = new Date(dateEvent.date).getDate();
			if (today === day) {
				result.push(dateEvent);
			}
		}

		return result;
	};

	eventCalendar.prototype.getCurrentMonthEvents = function() {
		// let currentMonth = new Date().getMonth() + 1;
		let currentMonth = that.currentMonthNum + 1;
		let month;

		if (!that.eventsData) return [];

		let result = [];

		for (let dateEvent of that.eventsData) {
			month = new Date(dateEvent.date).getMonth() + 1;
			if (currentMonth === month) {
				result.push(dateEvent);
			}
		}

		return result;
	};

	eventCalendar.prototype.setTranslatedLabel = function(language, labelArrEn, labelArrBg, index, htmlEl) {
		switch (language) {
			case 'en':
				htmlEl.innerHTML += '<h5>' + labelArrEn[index] + '</h5>';
				break;
			case 'bg':
				htmlEl.innerHTML += '<h5>' + labelArrBg[index] + '</h5>';
				break;
			default:
				htmlEl.innerHTML += '<h5>' + labelArrEn[index] + '</h5>';
				break;
		}
	};

	eventCalendar.prototype.checkRecentlyPastEvents = function() {
		const WEEKDAYS = 7;
		this.clearContainerById('previousEvents');
		this.clearContainerById('eventsSection');

		let pastWeekDates = this.getStrDatesFromCount('prev', WEEKDAYS);
		let nextWeekDates = this.getStrDatesFromCount('next', WEEKDAYS);
		let extractedPastEvents = this.extractEvents(pastWeekDates);
		// console.log(extractedPastEvents);
		let extractedNextWeekEvents = this.extractEvents(nextWeekDates);
		let currеntDayEvents = this.getCurrentDayEvents();
		let currentMontEvents = this.getCurrentMonthEvents();
		let eventCont = document.getElementById('eventsSection');
		let div = document.createElement('div');
		div.setAttribute('id', 'previousEvents');
		this.setTranslatedLabel(that.language, that.eventsLabelsEn, that.eventsLabelsBg, 0, div);
		let listPastEvents = this.generateList('ul', extractedPastEvents, 'previousEventsList', false);
		let listNextEvents = this.generateList('ul', extractedNextWeekEvents, 'nextEventsList', false);
		div.appendChild(listPastEvents);
		this.setTranslatedLabel(that.language, that.eventsLabelsEn, that.eventsLabelsBg, 1, div);
		div.appendChild(listNextEvents);
		this.setTranslatedLabel(that.language, that.eventsLabelsEn, that.eventsLabelsBg, 7, div);
		let listCurrentDayEvents = this.generateList('ul', currеntDayEvents, 'currentDayEvents', false);
		let listCurrentMontEvents = this.generateList('ul', currentMontEvents, 'currentMonthEvents', false);
		div.appendChild(listCurrentDayEvents);
		this.setTranslatedLabel(that.language, that.eventsLabelsEn, that.eventsLabelsBg, 8, div);
		div.appendChild(listCurrentMontEvents);
		eventCont.append(div);
	};

	eventCalendar.prototype.addThemeForMonth = function(currentMonth) {
		switch (currentMonth) {
			case 0:
				return that.darkThemes[0];
			case 1:
				return that.darkThemes[1];
			case 2:
				return that.darkThemes[2];
			case 3:
				return that.colorfulThemes[0];
			case 4:
				return that.colorfulThemes[1];
			case 5:
				return that.colorfulThemes[2];
			case 6:
				return that.colorfulThemes[3];
			case 7:
				return that.colorfulThemes[4];
			case 8:
				return that.darkThemes[3];
			case 9:
				return that.darkThemes[4];
			case 10:
				return that.colorfulThemes[5];
			case 11:
				return that.darkThemes[5];
			default:
				return that.darkThemes[0];
		}
		// let mainCont = document.getElementsByClassName('container')[0];
		// let eventsCont = document.getElementById('eventsContainer');
	};

	eventCalendar.prototype.checkBrowserSupportNotifications = function(){
		return window.Notification;
	}

	eventCalendar.prototype.createNotification = function(title, body, icon, event,timeleft){
		let notification = new Notification(title, {
			body: body,
			icon: window.document.URL.replace(/^(.*\/).*/, "$1") + icon
		});
		notification.onclick = function(e){
			e.preventDefault();
			// window.open(`https://192.168.0.125/evCalendar/events/showEventFromNotif/${event.id}`, '_blank');
			// window.open(`https://192.168.0.125/evCalendar/events/showEventFromNotif/${event.id}`);
			window.open(`https://192.168.0.125/evCalendar/events/showEventFromNotif?id=${event.id}&timeleft=${timeleft}`);
		}

		return notification;
	}

	eventCalendar.prototype.getAllEventsTodayTomorrow = function(){
		let todayDateObj = new Date();
		let today = this.formattedDate(todayDateObj);
		let tomorrowObj = new Date(todayDateObj);
		tomorrowObj.setDate(tomorrowObj.getDate() + 1);
		let tomorrow = this.formattedDate(tomorrowObj);
		return that.eventsData.filter(d => d.date === today || d.date == tomorrow);
	}

	eventCalendar.prototype.getHoursDiffByTwoDates = function(currentDateTime, eventDateAndHours){
		let diff =(eventDateAndHours.getTime() - currentDateTime.getTime()) / 1000;
		diff /= 60;
		return Math.round(diff);
	}


	eventCalendar.prototype.checkUpcomingEvents = function(events){
		let currentDateTime = new Date();
		let timeleft;
		let filteredEvents = events.filter(event => event.showNotification !== null);
		for(let event of filteredEvents){
			eventDateAndHours = new Date(event.date + ' ' + event.from);
			timeleft = this.getHoursDiffByTwoDates(currentDateTime, eventDateAndHours);
			if(timeleft >= 30 && timeleft <= 60){
				this.createNotification('Upcoming event in ' + timeleft +  ' mins. Start at ' + event.from + ' ' + this.reverseDateString(event.date), event.text, 'images/calendar.png', event, timeleft);
			}
			if(timeleft >= 10 && timeleft < 30){
				this.createNotification('Upcoming event in ' + timeleft  +  ' mins. Start at ' + event.from + ' ' + this.reverseDateString(event.date), event.text, 'images/calendar.png', event, timeleft);
			}
			if(timeleft < 10 && timeleft > 0){
				this.createNotification('Hurry up. Event begin in ' + timeleft  +  ' mins. Start at ' + event.from + ' ' + this.reverseDateString(event.date), event.text, 'images/calendar.png', event, timeleft);
			}
		}
	}
	
	eventCalendar.prototype.notificationModule = function(){
		//check if user is make settings to true of the app notifications
		if(that.userNotifPermission){
			//check if the current user`s browser support notifications. If not then turn them off
			if(!this.checkBrowserSupportNotifications()){
				that.setUserNotifPermission = false;
			}

			if(that.eventsData.length === 0){
				this.createNotification('Внимание', 'Все още няма въведени събития', '');	
				return;
			}
			
			let upcomingEvents = this.getAllEventsTodayTomorrow();
			if(upcomingEvents.length == 0){
				// this.createNotification('Внимание', 'Нямате събития за деня', '');	
				that.userNotifPermission = false;
				if(that.intervalCheckEventsNot){
					clearInterval(that.intervalCheckEventsNot);
					that.intervalCheckEventsNot = null;
				}
				return;
			}

			// this.checkUpcomingEvents(upcomingEvents);
			that.intervalCheckEventsNot = setInterval(() => this.checkUpcomingEvents(upcomingEvents), 300000);
			

		} else {
			if(that.intervalCheckEventsNot){
				clearInterval(that.intervalCheckEventsNot);
				that.intervalCheckEventsNot = null;
			}
		}
	}

	eventCalendar.prototype.createCalendar = function() {
		if (!that.container) {
			throw new Error('Problem with container. Invalid container - ' + that.container);
			return;
		}
		that.mainTheme = !that.useThemes ? '' : this.addThemeForMonth(new Date().getMonth());
		document.getElementsByClassName('container')[0].setAttribute('class', `container ${that.mainTheme}`);

		that.calendar = this.initializeCalendar();
		that.container.innerHTML = that.calendar;
		that.calendarTable = document.getElementById('evCalendar');
		that.calendarBody = document.getElementById('evCalendarBody');

		this.drawCalendarBody();
		this.addListenersToCalendar();
		this.checkRecentlyPastEvents();
		this.notificationModule();
		
		// this.checkUpcomingEvents();
		// document.getElementById('evCalendarBody').innerHTML += this.drawCalendarBody();
		// document.getElementById('evCalendarBody').innerHTML = '';
	};

	return eventCalendar;
})('simpleCalendarContainer');
