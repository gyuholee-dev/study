// document.addEventListener('DOMContentLoaded', async() => {
// $(document).ready(async function() { // DEPRECATED
$(async()=>{

    let dramaData = await $.getJSON('data/drama.json');
    // console.log(aaa);
    console.log(dramaData);

    // let bbb = await $.ajax('template.html');
    // console.log(bbb);
    // $('body').append($template);
    
});