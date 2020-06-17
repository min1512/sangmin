window.onload  = function() {
  
  console.log('orderJs load!!');

  // target offsetTop
  var targetOffsetTop = null;
  // html,body height \
  var el_html = document.querySelector('html');
  var el_body = document.querySelector('body');
  // calc br_roomlist offset.top
  var el_br_roomlist = document.querySelector('#br_wrapper #br_roomlist');
  var br_roomlist_top = null;

  // clac  summary heigth
  var el_summary = document.querySelector('#br_wrapper .summary');
  var summary_height = null;
  var summary_height_margin = 50;

  // clone summary
  var el_cln_summary = el_summary.cloneNode(true);
  el_cln_summary.classList.add('cln');
  el_br_roomlist.append(el_cln_summary);
  

  // init
  (function init(){
    br_roomlist_top = el_br_roomlist.offsetTop;
    summary_height = el_summary.offsetHeight + summary_height_margin;
    targetOffsetTop = br_roomlist_top - summary_height;
    document.querySelector('#br_roomlist').offsetHeight += summary_height;

    window.addEventListener('scroll',function(){
      this.console.log('window.scrollY ', window.scrollY);
      this.console.log('el_summary_top ', el_summary.offsetTop);

      // check hangon el_summary
      if(window.scrollY >= targetOffsetTop){
        this.console.log('bigger')
        if(!el_summary.classList.contains('on')){
          el_summary.classList.add('on');
          el_cln_summary.classList.add('on');
        }
      }else{
        if(el_summary.classList.contains('on')){
          el_summary.classList.remove('on');
          el_cln_summary.classList.remove('on');
        }
      }

      // end(cln summary delete)
      // when show summary element
      if(window.scrollY + window.innerHeight >= el_summary.offsetTop){
        this.console.log('end')
        el_summary.classList.remove('on');
        el_cln_summary.classList.remove('on');
      }

    });
    // scroll END
  })();



} // end