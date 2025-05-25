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
        template: "/templates/profile.html",
        title : "Profile",
        description : ""
    },

    "/message" : {
        template: "/templates/message.html",
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
    const location = window.location.pathname;
    if (location.length == 0){
        location = '/';
    }

    console.log(location);

    const route = urlRoutes[location] || urlRoutes[404];
    const html = await fetch(route.template).then((response) => response.text());

    document.getElementById("content").innerHTML = html;
    document.title = route.title + " | Bizou";

    document
    .querySelector('meta[name="description"]') // Use querySelector to get a single element
    .setAttribute("content", route.description);


    

}


window.onpopstate = urlLocationHandler;
window.route = urlRoute;

// window.addEventListener('hashchange', urlLocationHandler);

urlLocationHandler();