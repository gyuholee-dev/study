function shuffle(array) { 
    array.sort(() => Math.random() - 0.5); 
}
// 드라마 리스트 출력
async function renderList() {
    
    let listData = await $.getJSON('data/list.json');
    let dramaData = await $.getJSON('data/drama.json');

    let html = '';
    for (let category in listData) {
        let dramaList = '';
        let titles = Object.keys(dramaData[category]);
        shuffle(titles);
        for (let title of titles) {
            let url = dramaData[category][title];
            dramaList += `
                <a class="item" href="#">
                    <div class="img">
                        <img src="${url}" alt="${title}">
                    </div>
                    <div class="title">${title}</div>
                </a>
            `;
        }

        let listTitle = listData[category];
        html += `
            <section id="${category}" class="dramalist" data="0">
                <div class="title">
                    <label>${listTitle}</label>
                    <button class="btn more">더보기</button>
                </div>
                <div class="list">
                    <div class="items">
                        ${dramaList}
                    </div>
                    <div class="buttons nav">
                        <button class="btn prev disabled" data="${category}"></button>
                        <button class="btn next" data="${category}"></button>
                    </div>
                </div>     
            </section>
        `;
    }
    $(html).insertBefore($('#listend'));
    
}
let listReady = renderList();