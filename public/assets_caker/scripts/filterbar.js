let insightData = [];

const loadingPage = document.querySelector('.loading');

const contentWrapper = document.querySelector('.content-wrapper');
contentWrapper.style.marginRight = '230px';

// init render dashboard subdistrict filter bar
loadingPage.removeAttribute('hidden');
$.ajax({
  url: APP_URL + '/districts/3515',
  type: 'GET',
  dataType: 'json',
  success: function (data) {
    loadingPage.setAttribute('hidden', '');
    const filterMenu = document.querySelector('#filterMenu');

    data.forEach(function (district) {
      const item = document.createElement('li');
      item.classList.add('nav-item');

      const districtLink = document.createElement('a');
      districtLink.classList.add('nav-link');
      districtLink.classList.add('align-middle');
      districtLink.classList.add('text-white');
      districtLink.classList.add('district-link');

      const collapseID = `collapse${district.id}`;
      districtLink.setAttribute('data-bs-toggle', 'collapse');
      districtLink.setAttribute('href', `#${collapseID}`);
      districtLink.setAttribute('role', 'button');
      districtLink.setAttribute('aria-expanded', 'false');
      districtLink.setAttribute('aria-controls', collapseID);

      districtLink.innerHTML = `<i class="fa fa-angle-right" aria-hidden="true"></i> &nbsp; ${district.name}`;

      item.append(districtLink);

      const collapse = document.createElement('div');
      collapse.classList.add('collapse');
      collapse.id = collapseID;

      const ul = document.createElement('ul');

      district.sub_districts.forEach(function (subDistrict) {
        const li = document.createElement('li');
        li.classList.add('nav-item');

        const subDistrictLink = document.createElement('a');
        subDistrictLink.classList.add('nav-link');
        subDistrictLink.classList.add('align-middle');
        subDistrictLink.classList.add('text-white');
        subDistrictLink.classList.add('subdistrict-link');

        subDistrictLink.setAttribute('href', '#');
        subDistrictLink.setAttribute('nice-clicked', 'false');

        subDistrictLink.innerText = subDistrict.name;

        li.append(subDistrictLink);
        ul.append(li);

        subDistrictLink.addEventListener('click', function (e) {
          e.preventDefault();

          if (this.getAttribute('nice-clicked') === 'false') {
            const allSubDistrictText = document.querySelectorAll('#filterMenu li a.subdistrict-link');
            allSubDistrictText.forEach(function (singleElement) {
              deactivateSubDistrictLink(singleElement)
            });

            getSubDistrictEmployeesInfo(subDistrict.id);
            activateSubDistrictLink(this);
          } else {
            getAllEmployeesInfo();
            deactivateSubDistrictLink(this);
          }
        })
      });

      collapse.append(ul);
      item.append(collapse);
      filterMenu.append(item);

      districtLink.addEventListener('click', function (e) {
        e.preventDefault();

        if (this.getAttribute('aria-expanded') === 'true') {
          this.innerHTML = `<i class="fa fa-angle-down" aria-hidden="true"></i> &nbsp; ${district.name}`;

          this.classList.add('bg-white');
          this.classList.replace('text-white', 'text-black');
        } else {
          this.innerHTML = `<i class="fa fa-angle-right" aria-hidden="true"></i> &nbsp; ${district.name}`;

          this.classList.remove('bg-white');
          this.classList.replace('text-black', 'text-white');
        }
      });
    });
  }
});

function getAllEmployeesInfo() {
  loadingPage.removeAttribute('hidden');

  $.ajax({
    url: APP_URL + '/insight',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      loadingPage.setAttribute('hidden', '');

      insightData = data;
      render();
    }
  });
}

function getSubDistrictEmployeesInfo(subdistrict) {
  loadingPage.removeAttribute('hidden');

  $.ajax({
    url: APP_URL + '/insight?subdistrict=' + subdistrict,
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      loadingPage.setAttribute('hidden', '');

      insightData = data;
      render();
    }
  });
}

function activateSubDistrictLink(element) {
  element.setAttribute('nice-clicked', 'true');

  element.classList.add('bg-white');
  element.classList.replace('text-white', 'text-black');
}

function deactivateSubDistrictLink(element) {
  element.setAttribute('nice-clicked', 'false');

  element.classList.remove('bg-white');
  element.classList.replace('text-black', 'text-white');
}

function render() {
  const insightDataElements = document.querySelectorAll('.insight-total p');

  for (let i = 0; i < insightDataElements.length; i++) {
    insightDataElements[i].innerText = insightData[i];
  }
}