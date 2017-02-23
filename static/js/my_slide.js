(function(){
    function Slide(ele,options)
    {
        this.ele = $(ele);
        this.option = $.extend({
            speed: 1000,
            delay: 3000
        },options);

        this.states = [
            {'top':'50px','left':'0%',width: '200px',height: '200px',
            '&zindex': 1},
            {'top':'25px','left':'16%',width: '250px',height: '250px',
            '&zindex': 2},
            {'top':'0px','left':'37%',width: '300px',height: '300px',
            '&zindex': 3},
            {'top':'25px','left':'63%',width: '250px',height: '250px',
            '&zindex': 2},
            {'top':'50px','left':'85%',width: '200px',height: '200px',
            '&zindex': 1}
        ];

        this.lis = this.ele.find('li');
        this.interval;
        //下面这两个绑定函数到左右移动的按键上的代码里面的.bind是为了让这个函数里的this使用作为bind参数的this，防止this的使用出现混淆
        //比如说没有.bind(this)的话，点击事件回调函数里面的this就是span:nth-child(1)这个元素本身而不是使用了Slide函数构造的对象，会出现找不到stop等函数的错误
        this.ele.children('span:nth-child(1)').click(function(){
            this.stop();
            this.next();
            this.play();
        }.bind(this));

        this.ele.children('span:nth-child(2)').click(function(){
            this.stop();
            this.prev();
            this.play();
        }.bind(this));

        this.move();
        this.play();
    };

    Slide.prototype = {
        move:function(){
            //这里要先更改zindex再移动，要不然的话会出现图片都移到最前面了zindex还是低一层的情况
            this.lis.each(function(i,el){
                $(el).css('z-index',this.states[i]['&zindex']).animate(this.states[i],this.option.speed)
            }.bind(this));
        },

        next:function(){
            this.states.unshift(this.states.pop());
            this.move();
        },

        prev:function(){
            this.states.push(this.states.shift());
            this.move();
        },
        //setInterval方法是js中的window对象的一个方法，作用时根据给定的时间间隔定期调用传给他的方法
        play:function(){
            this.interval = setInterval(function(){
                this.next();
            }.bind(this),this.option.delay);
        },

        stop:function(){
            clearInterval(this.interval);
        }
    };
    //$.fn.xxx=function()这种形式的效果是所有jquery实例都有这个方法可以调用
    $.fn.mySlide = function(options){
        this.each(function(i,ele){
            new Slide(ele,options)
        });
        return this;
    };
})()