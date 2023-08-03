
require(['jquery', 'domReady!'], function($){
    var $bt = $('#backtotop');
    const handleScroll = () => {
        if (window.scrollY > 600) {
            $bt.fadeIn();
        }
        else {
            $bt.fadeOut();
        }
    }
    
    window.addEventListener("scroll", handleScroll);
    
    $bt.on('click touch',function() {
        window.scroll({top:0,behavior:"smooth" });
        return false;
    });
});

