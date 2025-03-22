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

const routes = {
    404: {
        template: "/templates/404.html",
        title : "Page Not Found",
        description : ""
    },

    "/": {
        template: "../templates/home.html",
        title : "Home",
        description : ""
    },

    login: {
        template: "../templates/login.html",
        title : "Login",
        description : ""
    },

    register: {
        template: "../templates/register.html",
        title : "Register",
        description : ""
    },

    message : {
        template: "../templates/message.html",
        title : "Message",
        description : ""
    }
}


const locationHandler = async () => {
    var location = window.location.hash.replace("#", "");
    if (location.length == 0){
        location = '/';
    }

    console.log(location);

    const route = routes[location] || routes[404];
    const contentElement = document.getElementById("content");
    
    // Use the animation function
    await animatePageTransition(contentElement, route);
}

window.addEventListener('hashchange', locationHandler);

locationHandler();



