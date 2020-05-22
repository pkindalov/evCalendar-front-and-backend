// let formContainer = document.getElementById('mailForm');
function addContent(slicedData) {
	mainContainer.innerHTML = '';
	for (let index = 0; index < slicedData.length - 1; index++) {
		let content = slicedData[index].html;
		let contentId = slicedData[index].id;
		let cardDiv = `<div id="event-${contentId}" class="col l12 m7">
                        <div class="card horizontal">
                          <div class="card-image"></div>
                          <div class="card-stacked">
                            <div class="card-content">
                            <div class="mailField">
                                <label>
                                  <input id="checkboxEvent${contentId}" type="checkbox" />
                                    <span>Choose to send</span>
                                </label>
                              </div>
                              <p>${content}</p>
                            </div>
                          </div>
                        </div>
                      </div>`;
		mainContainer.innerHTML += cardDiv;
	}

	addPrevNextBtns();
}

function addPrevNextBtns() {
	let mainContainer = document.getElementById('eventContId');
	let nextBtn = document.createElement('a');
	nextBtn.setAttribute('href', '#');
	nextBtn.setAttribute('class', 'btn');
	// nextBtn.innerText = 'Next';
	nextBtn.innerHTML += `
        <span class="material-icons alignVertically">
             navigate_next
        </span>
        <span>Next</span>
    `;
	nextBtn.onclick = () => {
		that.page++;
		that.offset = (that.page - 1) * that.pageSize;
		let newData = data.slice(that.offset, that.pageSize + that.offset);
		addContent(newData);
	};
	mainContainer.append(nextBtn);

	showMailForm = false;
	formContainer.style.display = 'none';
	// if (that.offset + that.pageSize <= that.data.length) {
	// }

	if (that.page > 1) {
		let prevBtn = document.createElement('a');
		prevBtn.setAttribute('href', '#');
		prevBtn.setAttribute('class', 'btn leftMargin');
		// prevBtn.setAttribute('class', 'leftMargin');
		// prevBtn.innerText = 'Prev';
		prevBtn.innerHTML += `
        <span class="material-icons alignVertically">
             navigate_before
        </span>
        <span>Prev</span>
    `;
		prevBtn.onclick = () => {
			that.page--;
			that.offset = (that.page - 1) * that.pageSize;
			let newData = data.slice(that.offset, that.offset + that.pageSize);
			addContent(newData);
		};
		mainContainer.append(prevBtn);
		showMailForm = false;
		formContainer.style.display = 'none';
	}
}
