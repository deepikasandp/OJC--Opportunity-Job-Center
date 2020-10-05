/* Progress Bar */
function move(n) {
    var el = document.getElementById("myBar");
    el.style.width += n;
}

/* Toggle Update Profile Form */
function showUpdateForm() {
    var updateProfileId = document.getElementById('updateForm');
    var viewProfileId = document.getElementById('showProfile');
    var viewOfferId = document.getElementById('showOffers');
    var updateProfileLink = document.getElementById('updateProfileLink');
    var viewProfileLink = document.getElementById('showProfileLink');
    var viewOffersLink = document.getElementById('showOffersLink');
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

    contains = viewOfferId.classList.contains("show");
    if(contains)
    {
        viewOfferId.classList.remove('show');
    }
    contains = viewOfferId.classList.contains("hide");
    if(!contains)
    {
        viewOfferId.classList.add('hide');
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
    contains = viewOffersLink.classList.contains("active");
    if(contains)
    {
        viewOffersLink.classList.remove('active');
    }
    contains = updateProfileLink.classList.contains("active");
    if(!contains){
        updateProfileLink.classList.add('active');
    }
}

/* Toggle Show Profile */
function showUpdatedProfile() {
    var updateProfileId = document.getElementById('updateForm');
    var viewProfileId = document.getElementById('showProfile');
    var viewOfferId = document.getElementById('showOffers');
    var updateProfileLink = document.getElementById('updateProfileLink');
    var viewProfileLink = document.getElementById('showProfileLink');
    var viewOffersLink = document.getElementById('showOffersLink');
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

    contains = viewOfferId.classList.contains("show");
    if(contains)
    {
        viewOfferId.classList.remove('show');
    }
    contains = viewOfferId.classList.contains("hide");
    if(!contains)
    {
        viewOfferId.classList.add('hide');
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
    contains = viewOffersLink.classList.contains("active");
    if(contains)
    {
        viewOffersLink.classList.remove('active');
    }
    contains = viewProfileLink.classList.contains("active");
    if(!contains){
        viewProfileLink.classList.add('active');
    }
}

/* Toggle Show Profile */
function viewOffers() {
    var updateProfileId = document.getElementById('updateForm');
    var viewProfileId = document.getElementById('showProfile');
    var viewOfferId = document.getElementById('showOffers');
    var updateProfileLink = document.getElementById('updateProfileLink');
    var viewProfileLink = document.getElementById('showProfileLink');
    var viewOffersLink = document.getElementById('showOffersLink');
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
    if(contains)
    {
        viewProfileId.classList.remove('show');
    }
    contains = viewProfileId.classList.contains("hide");
    if(!contains)
    {
        viewProfileId.classList.add('hide');
    }

    contains = viewOfferId.classList.contains("show");
    if(!contains){
        viewOfferId.classList.add('show');
    }
    contains = viewOfferId.classList.contains("hide");
    if(contains){
        viewOfferId.classList.remove('hide');
    }


    contains = updateProfileLink.classList.contains("active");
    if(contains)
    {
        updateProfileLink.classList.remove('active');
    }
    contains = viewProfileLink.classList.contains("active");
    if(contains)
    {
        viewProfileLink.classList.remove('active');
    }
    contains = viewOffersLink.classList.contains("active");
    if(!contains){
        viewOffersLink.classList.add('active');
    }
}