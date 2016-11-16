(function() {
	var menu = document.getElementById("menu");
	var nav  = menu.firstElementChild;
	var button = document.createElement("div");
	var icon = document.createElement("img");
	var buttonInserted = false;
	var menuOpen = false;

	function addButton() {
		button.id = "menu-button";
		button.textContent =
		button.addEventListener("click", showHideMenu);
		icon.src = "img/menu.svg";
		icon.alt = "Menu";
		button.insertBefore(icon, button.firstChild);
		menu.insertBefore(button, menu.firstChild);
		buttonInserted = true;
	}

	function prepareMenu(mq) {
		buttonInserted || addButton();
		if(mq.matches) {
			button.style.display = "";
			blockifyMenu(true);
			restoreMenu();
		} else {
			button.style.display = "none";
			blockifyMenu(false);
			showMenu();
		}
	}

	function blockifyMenu(block) {
		if(block) {
			nav.classList.add("block");
		} else {	
			nav.classList.remove("block");
		}
	}

	function restoreMenu() {
		if(menuOpen) {
			showMenu();
		} else {
			hideMenu();
		}
	}

	function showHideMenu() {
		if (menuOpen) {
			hideMenu();
			menuOpen = false;
		} else {
			showMenu();
			menuOpen = true;
		}
	}

	function showMenu() {
		nav.style.display = "block";
		menu.className = "open";
		icon.src = "img/menu.svg";
	}

	function hideMenu() {
		nav.style.display = "none";
		menu.className = "";
		icon.src = "img/menulight.svg";
	}

	var mq = window.matchMedia("(max-width: 34em)");
	mq.addListener(prepareMenu);
	prepareMenu(mq);
}());

