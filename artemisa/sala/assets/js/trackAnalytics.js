function trackPage(page, title){
    if(ANALYTICS !== false){
        ga('send', {
            hitType: 'pageview',
            page: page,
            title: title
        });
    }
}

