var collapseBtn = document.getElementById('collapse-button');
var sidebar = document.getElementById('sidebar');
var range = document.getElementById('range');
var select = document.getElementById('select-title');
var min = document.getElementById('min');
var buttonStart = document.getElementById('button-start');
var buttonPrevious = document.getElementById('button-previous');
var buttonNext = document.getElementById('button-next');
var buttonEnd = document.getElementById('button-end');

var text = "";
var title = "";
var minChecked = false;
var accuracy = 0.5;
var selectFrom = 0;
var offset = 20;
var dataObj = [];
var recommendedObj = [];
var recommendedSpecialObj = [];
var originalObj = [];
var originalSpecialObj = [];


buttonStart.addEventListener('click', function() {
  selectFrom = 0;
  fetchData();

})

buttonPrevious.addEventListener('click', function() {
  selectFrom = selectFrom - 20;
  if(selectFrom < 0) {
    selectFrom = dataObj.length - 20;
  }
  fetchData();
})

buttonNext.addEventListener('click', function() {
  console.log(selectFrom);
  console.log(dataObj.length);
  selectFrom = selectFrom + 20;
  if(selectFrom + offset >= dataObj.length) {
    selectFrom = 0;
  }
  fetchData();
})

buttonEnd.addEventListener('click', function() {
  selectFrom = dataObj.length - 20;
  fetchData();
})

min.addEventListener('change', function() {
  minChecked = !minChecked;
  addlabel("original-labels", originalObj);
  addlabel("recommended-labels", recommendedObj);
  addlabel("recommended-spec-labels", recommendedSpecialObj);
  addlabel("original-spec-labels", originalSpecialObj);
});

(function () {
  fetchData();
  accuracy = range.value;
  document.getElementById('range-value').textContent = range.value;
})();

collapseBtn.addEventListener('click', function() {
  sidebar.classList.toggle('active');
});

range.addEventListener('input', function(e) {
  accuracy = e.target.value;
  document.getElementById('range-value').textContent = e.target.value;
  addlabel("original-labels", originalObj);
  addlabel("recommended-labels", recommendedObj);
  addlabel("recommended-spec-labels", recommendedSpecialObj);
  addlabel("original-spec-labels", originalSpecialObj);
});

function fetchData(url = 'data.txt') {
  dataObj = [];
  fetch(url = '')
    .then((response) => response.text())
    .then((text) => text.split('\n'))
    .then((text) => text.map((line) => line.split('$$$')))
    .then((text) => {
      var obj = {};
      var indx = 0;
      text.forEach((line) => {
        obj.recommended = line[0];
        obj.recommendedSpec = line[1];
        obj.original = line[2];
        obj.title = line[3];
        obj.text = line[4];
        obj.id = indx++;

        dataObj.push(obj);
        obj = {};
      });
      select.innerHTML = "";

      dataObj.map((data, index) => {
        if(index >= selectFrom && index < (selectFrom + offset)) {
          var option = document.createElement('option');
          option.innerText = data.title;
          option.value = data.title;
          select.appendChild(option);
        }
      })
    });
};
function processData(url = 'data.txt') {
  fetch(url = '')
    .then((response) => response.text())
    .then((text) => text.split('$$$'))
    .then((text) => {
      console.log(text);
      let i = 0;
      let tempObj = {};

      text.map((data) => {
        if (i == 0) {
          tempObj.recommended = data;
          i++;
        } else if (i == 1) {
          tempObj.recommendedSpec = data;
          i++;
        } else if (i == 2) {
          tempObj.original = data;
          i++;
        } else if (i == 3) {
          tempObj.title = data;
          i++;
        } else if (i == 4) {
          tempObj.text = data;
          processedData.push(tempObj);
          tempObj = {};
          i = 0;
        } else {
          console.log('Error occured while processing the data');
        }
      });
    });
}();

select.addEventListener('change', function(e) {
  var option = dataObj.find(d => d.title == e.target.value);
  console.log()
  getDataFromText(option);
});

var getDataFromText = function(data) {
  recommendedObj = [];
  recommendedSpecialObj = [];
  originalObj = [];
  originalSpecialObj = [];
  var tempObj = {};
  console.log(data);
  var recommended = data.recommended.split(' '); 
  var recommendedSpec = data.recommendedSpec.split(' '); 
  var original = data.original.split(' ');
  text = data.text;
  title = data.title;
  
  recommended.forEach(item => {
    if(item.trim().startsWith('__label__')) {
      tempObj.label = item.replace("__label__", "").replace(/@{2}/g, " ");
    }else if(item != "") {
      tempObj.accuracy = item.trim();
      recommendedObj.push(tempObj);
      tempObj = {};
      
    }
  });

  recommendedSpec.forEach(item => {
    if(item.trim().startsWith('__label__')) {
      tempObj.label = item.replace("__label__", "").replace(/@{2}/g, " ");
    }else if(item != "") {
      tempObj.accuracy = item.trim();
      recommendedSpecialObj.push(tempObj);
      tempObj = {};
    }
  });
  original.forEach(item => {
    if(item.trim().startsWith('__label__')) {
      tempObj.label = item.replace("__label__", "").replace(/@{2}/g, " ");
      originalObj.push(tempObj);
      tempObj = {};
    }else if(item != "") {
      tempObj.label = item.replace(/@{2}/g, " ");
      originalSpecialObj.push(tempObj);
      tempObj = {};
    }
  });

  var elem = document.getElementById("text-content");

  elem.innerHTML = text;
  
  addlabel("original-labels", originalObj);
  addlabel("recommended-labels", recommendedObj);
  addlabel("recommended-spec-labels", recommendedSpecialObj);
  addlabel("original-spec-labels", originalSpecialObj);
}

var addlabel = function(nodeId, data = []) {
  console.log(data);
  var node = document.getElementById(nodeId);
  node.innerHTML = "";
  if(minChecked) {
    for(var i = 0; i < data.length && i < 3; i++) {
      var list = document.createElement('li');
        if (data[i].accuracy !== undefined) {
          list.textContent = `${data[i].label} ${data[i].accuracy}`;
        }else {
          list.textContent = data[i].label;
        }
        node.appendChild(list);
    }

    for(var i = 3; i < data.length; i++) {
      if(data[i].accuracy !== undefined) {
        if(data[i].accuracy >= accuracy) {
          var list = document.createElement('li');
          if (data[i].accuracy !== undefined) {
            list.textContent = `${data[i].label} ${data[i].accuracy}`;
          }else {
            list.textContent = data[i].label;
          }
          node.appendChild(list);
        }
      } else {
        var list = document.createElement('li');
        if (data[i].accuracy !== undefined) {
          list.textContent = `${data[i].label} ${data[i].accuracy}`;
        }else {
          list.textContent = data[i].label;
        }
        node.appendChild(list);
      }
    }
  } else {
    for(var i = 0; i < data.length; i++) {
      if(data[i].accuracy !== undefined) {
        if(data[i].accuracy >= accuracy) {
          var list = document.createElement('li');
          if (data[i].accuracy !== undefined) {
            list.textContent = `${data[i].label} ${data[i].accuracy}`;
          }else {
            list.textContent = data[i].label;
          }
          node.appendChild(list);
        }
      } else {
        var list = document.createElement('li');
        if (data[i].accuracy !== undefined) {
          list.textContent = `${data[i].label} ${data[i].accuracy}`;
        }else {
          list.textContent = data[i].label;
        }
        node.appendChild(list);
      }
    }
  }
};