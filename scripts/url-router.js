const animatePageTransition = async (element, route) => {
    // Start exit animation
    element.classList.add('page-transition', 'page-exit');
    
    // Wait for exit animation to complete
    return new Promise(resolve => {
        setTimeout(async () => {
            // Add the enter classes
            element.classList.remove('page-exit');
            element.classList.add('page-enter');
            
            // Fetch and update content
            const html = await fetch(route.template).then((response) => response.text());
            element.innerHTML = html;
            document.title = route.title + " | Bizou";
            
            // Start enter animation
            setTimeout(() => {
                element.classList.remove('page-enter');
                element.classList.add('page-enter-active');
                
                // Clean up classes after animation completes
                setTimeout(() => {
                    element.classList.remove('page-transition', 'page-enter-active');
                    resolve();
                }, 400);
            }, 10);
        }, 300);
    });
} // <-- Fait par ChatGPT

// https://www.youtube.com/watch?v=JmSb1VFoP7w
console.log("Hash Router Loaded");
document.addEventListener("click", (e) => {
	const { target } = e;
	if (!target.matches("nav a")) {
		return;
	}
	e.preventDefault();
	urlRoute();
});

const urlRoutes = {
    404: {
        template: "/templates/404.html",
        title : "Page Not Found",
        description : ""
    },

    "/": {
        template: "/templates/home.php",
        title : "Home",
        description : ""
    },

    "/login": {
        template: "/templates/login.html",
        title : "Login",
        description : ""
    },

    "/register": {
        template: "/templates/register.html",
        title : "Register",
        description : ""
    },

    "/profile": {
        template: "/templates/profile.php",
        title : "Profile",
        description : ""
    },

    "/publish" : {
        template: "/templates/publish.php",
        title : "Message",
        description : ""
    }
}

const urlRoute = (event) => {
	event = event || window.event; // get window.event if event argument not provided
	event.preventDefault();
	// window.history.pushState(state, unused, target link);
	window.history.pushState({}, "", event.target.href);
	urlLocationHandler();
};

const urlLocationHandler = async () => {
    let location = window.location.pathname;
    if (location.length == 0) {
        location = "/";
    }

    let route = urlRoutes[location] || urlRoutes[404];
    let templatePath = route.template;

    // Extract reply_to from URL
    const urlParams = new URLSearchParams(window.location.search);
    const replyTo = urlParams.get('reply_to');

    // Fetch the template
    let html = await fetch(templatePath).then((response) => response.text());

    // Replace a placeholder in the template with the replyTo value
    html = html.replace('<!--REPLACE_WITH_REPLY_TO-->', replyTo ? replyTo : '');

    document.getElementById("content").innerHTML = html;
    // await animatePageTransition(document.getElementById("content"), route);
    document.title = route.title + " | Bizou";

    document
        .querySelector('meta[name="description"]')
        .setAttribute("content", route.description);
};


window.onpopstate = urlLocationHandler;
window.route = urlRoute;

// window.addEventListener('hashchange', urlLocationHandler);

urlLocationHandler();