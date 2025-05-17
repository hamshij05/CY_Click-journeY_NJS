
document.addEventListener('DOMContentLoaded', function () {

    // DARK / LIGHT MODE
    const themeButton = document.getElementById("toggle-theme");
    const themeLink = document.getElementById("theme-link");
  
    const savedTheme = getCookie("theme");
    setTheme(savedTheme === "dark" ? "dark" : "light");
  
    themeButton?.addEventListener("click", function () {
      const currentTheme = themeLink.getAttribute("href").includes("darkstyles.css") ? "dark" : "light";
      const newTheme = currentTheme === "light" ? "dark" : "light";
      setTheme(newTheme);
    });
  
    function setTheme(theme) {
      themeLink.setAttribute("href", theme === "dark" ? "assets/css/darkstyles.css" : "assets/css/styles.css");
      setCookie("theme", theme, 30);
      themeButton.innerHTML = theme === "dark" ? "🌙 Mode nuit" : "☀️ Mode clair";
    }
  
    function setCookie(name, value, days) {
      const expires = new Date(Date.now() + days * 864e5).toUTCString();
      document.cookie = name + "=" + value + "; expires=" + expires + "; path=/";
    }
  
    function getCookie(name) {
      return document.cookie.split('; ').find(row => row.startsWith(name + '='))?.split('=')[1];
    }


  
    // TOGGLE FOR PASSWORD
    document.querySelectorAll(".toggle-password").forEach(icon => {
      const target = document.querySelector(icon.dataset.target);
      if (!target) return;
      icon.addEventListener("click", () => {
        const hidden = target.type === "password";
        target.type = hidden ? "text" : "password";
        icon.classList.toggle("bx-show", !hidden);
        icon.classList.toggle("bx-hide", hidden);
      });
    });



  
    // FORM FOR DURATION
    const durationSelect = document.getElementById('duration');
    const firstThemeGroup = document.getElementById('first-theme-group');
    const firstRegionGroup = document.getElementById('first-region-group');
    const secondThemeGroup = document.getElementById('second-theme-group');
    const secondRegionGroup = document.getElementById('second-region-group');
    const transportGroup = document.getElementById('transport-group');
    const hotelGroup = document.getElementById('hotel-group');
  
    function updateFormVisibility() {
      const duration = durationSelect?.value;
      if (!duration) return;
  
      const isTen = duration === "10";
      const show = el => el && (el.style.display = "block");
      const hide = el => el && (el.style.display = "none");
  
      show(firstThemeGroup); show(firstRegionGroup); show(transportGroup); show(hotelGroup);
      isTen ? show(secondThemeGroup) : hide(secondThemeGroup);
      isTen ? show(secondRegionGroup) : hide(secondRegionGroup);
  
      document.getElementById('first-theme').required = true;
      document.getElementById('first-region').required = true;
      document.getElementById('second-theme').required = isTen;
      document.getElementById('second-region').required = isTen;
    }
  
    durationSelect?.addEventListener('change', updateFormVisibility);
    updateFormVisibility();
  



    // COUNTER CHAR
    const fields = [
      { selector: 'input[name="login"]', max: 20 },
      { selector: 'input[name="email"]', max: 50 },
      { selector: 'input[name="first_name"]', max: 30 },
      { selector: 'input[name="surname"]', max: 30 }
    ];
  
    fields.forEach(f => {
      const input = document.querySelector(f.selector);
      if (input) {
        const counter = document.createElement('div');
        counter.className = 'char-counter';
        counter.style.cssText = 'font-size:12px;color:#FAF3E0;text-align:right;margin-top:2px;font-style:italic;';
        input.parentNode.insertBefore(counter, input.nextSibling);
        input.addEventListener('input', () => {
          const len = input.value.length;
          counter.textContent = `${len} caractère(s)`;
          counter.style.color = len > f.max ? '#A42020' : '#FAF3E0';
          counter.style.fontWeight = len > f.max ? 'bold' : 'normal';
        });
        input.dispatchEvent(new Event('input'));
      }
    });
  



    // VALIDATE FORM
    const loginForm = document.querySelector('form[action="../login_form.php"]');
    const signupForm = document.querySelector('form[action="../sign_up.php"]');
  
    if (!document.getElementById('error-container')) {
      const container = document.createElement('div');
      container.id = 'error-container';
      container.className = 'error-message';
      const header = document.querySelector('.login-header');
      if (header) header.parentNode.insertBefore(container, header.nextSibling);
    }
  
    loginForm?.addEventListener('submit', function(e) {
      const login = loginForm.querySelector('input[name="login"]').value.trim();
      const pwd = loginForm.querySelector('input[name="password"]').value;
      const errors = [];
      if (!login) errors.push("Veuillez saisir votre identifiant");
      if (!pwd) errors.push("Veuillez saisir votre mot de passe");
      handleErrors(e, errors);
    });
  
    signupForm?.addEventListener('submit', function(e) {
      const f = signupForm;
      const errors = [];
      const get = name => f.querySelector(`input[name="${name}"]`).value.trim();
      const pw = f.querySelector('input[name="password"]').value;
      const cpw = f.querySelector('input[name="confirm_password"]').value;
  
      if (!get('first_name')) errors.push("Le prénom est requis");
      if (!get('surname')) errors.push("Le nom est requis");
      if (!get('email')) errors.push("L'email est requis");
      else if (!isValidEmail(get('email'))) errors.push("L'email n'est pas valide");
      if (!get('login')) errors.push("L'identifiant est requis");
      if (!pw) errors.push("Le mot de passe est requis");
      else validatePasswordComplexity(pw).forEach(e => errors.push(e));
      if (!cpw) errors.push("La confirmation du mot de passe est requise");
      else if (pw !== cpw) errors.push("Les mots de passe ne correspondent pas");
  
      handleErrors(e, errors);
    });
  });



  
  // OTHERS
  function handleErrors(event, messages) {
    const box = document.getElementById('error-container');
    box.innerHTML = '';
    if (messages.length > 0) {
      messages.forEach(msg => {
        const p = document.createElement('p');
        p.textContent = msg;
        p.style.cssText = 'margin:5px 0;color:#A42020;';
        box.appendChild(p);
      });
      box.style.display = 'block';
      event.preventDefault();
    } else {
      box.style.display = 'none';
    }
  }
  
  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
  
  function validatePasswordComplexity(pw) {
    const e = [];
    if (pw.length < 12) e.push("Le mot de passe doit contenir au moins 12 caractères");
    if (!/[A-Z]/.test(pw)) e.push("Le mot de passe doit contenir au moins une majuscule");
    if (!/[a-z]/.test(pw)) e.push("Le mot de passe doit contenir au moins une minuscule");
    if (!/[0-9]/.test(pw)) e.push("Le mot de passe doit contenir au moins un chiffre");
    if (!/[\W]/.test(pw)) e.push("Le mot de passe doit contenir au moins un caractère spécial");
    return e;
  }
  



//soted admin page
  document.addEventListener("DOMContentLoaded", function () {
    const headers = document.querySelectorAll("th[data-sort]");
    headers.forEach(header => {
      header.style.cursor = "pointer";
      header.addEventListener("click", function () {
        const sortKey = this.dataset.sort;
        const tbody = document.querySelector(".client-table tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));
  
        const order = this.dataset.order === "asc" ? "desc" : "asc";
        this.dataset.order = order;
  
        rows.sort((a, b) => {
          let valA = a.dataset[sortKey];
          let valB = b.dataset[sortKey];
  
          if (!isNaN(valA) && !isNaN(valB)) {
            valA = parseFloat(valA);
            valB = parseFloat(valB);
          }
  
          return order === "asc"
            ? valA > valB ? 1 : -1
            : valA < valB ? 1 : -1;
        });
  
        rows.forEach(row => tbody.appendChild(row));
      });
    });
  });
  


// price

document.addEventListener("DOMContentLoaded", function () {
    const durationSelect = document.getElementById("duration");
    const region1Select = document.getElementById("first-region");
    const region2Select = document.getElementById("second-region");
    const transportSelect = document.getElementById("transport");
    const hotelSelect = document.getElementById("hotel");
    const travelersInput = document.getElementById("travelers");
    const priceDisplay = document.getElementById("price");
  
    

    function generatePrice(theme, region1, region2, duration, transport = 'standard', hotel = 'standard') {
      let basePrice = 3500;
      if (region1 === 'kansai') basePrice += 200;
      if (region2 === 'kansai') basePrice += 200;
      if (duration === 5) basePrice = Math.round(basePrice / 2);
      if (transport === 'vip') basePrice += 100;
      if (hotel === 'vip') basePrice += 150;
      return basePrice;
    }
  
    function updatePrice() {
      const duration = parseInt(durationSelect?.value || "5");
      const region1 = region1Select?.value || "";
      const region2 = region2Select?.value || "";
      const transport = transportSelect?.value || "standard";
      const hotel = hotelSelect?.value || "standard";
      const travelers = parseInt(travelersInput?.value || "1");
  
      const unitPrice = generatePrice('', region1, region2, duration, transport, hotel);
      const totalPrice = unitPrice * travelers;
  
      priceDisplay.textContent = totalPrice.toLocaleString('fr-FR') ;
    }
  
    [durationSelect, region1Select, region2Select, transportSelect, hotelSelect, travelersInput].forEach(el => {
      if (el) el.addEventListener("change", updatePrice);
    });
  
    updatePrice();
  });
  