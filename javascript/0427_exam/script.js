// document.addEventListener('DOMContentLoaded', async() => {
// $(document).ready(async function() { // DEPRECATED
$(async()=>{

    // let header = 'header';
    // let main = 'main';
    // let footer = 'footer';
    // // 로그 출력
    // const template = await xhr('loadFile', {'file':'template.html'});
    // let $template = $(template);
    // $('body').append($template);

    let dramaData = await $.getJSON('data/drama.json');
    // console.log(aaa);
    console.log(dramaData);

    // let bbb = await $.ajax('template.html');
    // console.log(bbb);
    
});