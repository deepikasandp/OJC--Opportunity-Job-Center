var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("updateVacancyForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

/* Progress Bar */
function move(n) {
  var el = document.getElementById("myBar");
  el.style.width += n;
}

/* Toggle Update Profile Form */
function addNewVacancy() {
  var updateProfileId = document.getElementById('addVacancy');
  var viewProfileId = document.getElementById('showVacancies');
  var updateProfileLink = document.getElementById('addVacancyLink');
  var viewProfileLink = document.getElementById('showVacancyLink');
  var contains;

  contains = viewProfileId.classList.contains("show");
  if(contains)
  {
      viewProfileId.classList.remove('show');                
  }
  contains = viewProfileId.classList.contains("hide");
  if(!contains)
  {
      viewProfileId.classList.add('hide');                
  }

  contains = updateProfileId.classList.contains("show");
  if(!contains){
      updateProfileId.classList.add('show');
  }
  contains = updateProfileId.classList.contains("hide");
  if(contains){
      updateProfileId.classList.remove('hide');
  }

  contains = viewProfileLink.classList.contains("active");
  if(contains)
  {
      viewProfileLink.classList.remove('active');
  }
  
  contains = updateProfileLink.classList.contains("active");
  if(!contains){
      updateProfileLink.classList.add('active');
  }
}

/* Toggle Show Profile */
function showAllVacancies() {
  var updateProfileId = document.getElementById('addVacancy');
  var viewProfileId = document.getElementById('showVacancies');
  var updateProfileLink = document.getElementById('addVacancyLink');
  var viewProfileLink = document.getElementById('showVacancyLink');
  var contains; 
  
  contains = updateProfileId.classList.contains("show");
  if(contains)
  {
      updateProfileId.classList.remove('show');
  }
  contains = updateProfileId.classList.contains("hide");
  if(!contains)
  {
      updateProfileId.classList.add('hide');
  }

  contains = viewProfileId.classList.contains("show");
  if(!contains){
      viewProfileId.classList.add('show');
  }
  contains = viewProfileId.classList.contains("hide");
  if(contains){
      viewProfileId.classList.remove('hide');
  }

  contains = updateProfileLink.classList.contains("active");
  if(contains)
  {
      updateProfileLink.classList.remove('active');
  }

  contains = viewProfileLink.classList.contains("active");
  if(!contains){
      viewProfileLink.classList.add('active');
  }
}
