// 리스트 출력
// document.addEventListener('DOMContentLoaded', async() => {
// $(document).ready(async function() { // DEPRECATED
$(async()=>{

    let listData = await $.getJSON('data/list.json');
    let dramaData = await $.getJSON('data/drama.json');
    // console.log(listData);
    // console.log(dramaData);

    let html = '';
    for (let category in listData) {
        let title = listData[category];
        html += `
            <section class="list thum">
                <div class="title">
                    <label>${title}</label>
                    <button class="btn more">더보기</button>
                </div>
                <div class="list">
        `;
        
        let list = '';
        for (let title in dramaData[category]) {
            let url = dramaData[category][title];
            list += `
                <a class="item" href="#">
                    <img src="${url}" alt="${title}">
                    <div class="info">${title}</div>
                </a>
            `;
        }
        html += list;

        html += `
                </div>     
            </section>
        `;
    }
    $(html).insertBefore($('#listend'));
    
});