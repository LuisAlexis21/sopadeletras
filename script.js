// Temas del juego
const themes = {
    animales: ["PERRO", "GATO", "ELEFANTE", "TIGRE", "LEON", "CONEJO"],
    paises: ["ARGENTINA", "MEXICO", "CANADA", "ESPANIA", "BRASIL", "FRANCIA"],
    frutas: ["MANZANA", "PLATANO", "FRESA", "CIRUELA", "MANGO", "KIWI"],
    deportes: ["FUTBOL", "BASKET", "TENNIS", "VOLEIBOL", "GIMNASIA", "RUGBY"],
    musica: ["ROCK", "POP", "JAZZ", "CLASICA", "HIPHOP", "BLUES"],
    colores: ["ROJO", "AZUL", "VERDE", "AMARILLO", "NARANJA", "MORADO"],
    peliculas: ["INCEPTION", "GLADIATOR", "TITANIC", "MATRIX", "AVATAR", "ALIEN"]
};

let words = [];
let gridSize = 10;
let wordGrid;
let currentSelection = [];
let wordsFound = [];
let timerInterval;
let startTime;

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('startGame').addEventListener('click', startNewGame);
    document.getElementById('generateNew').addEventListener('click', startNewGame);
    document.getElementById('closeWinModal').addEventListener('click', closeWinModal);

    document.getElementById('winModal').style.display = 'none'; // Ocultar el modal de victoria al comenzar un nuevo juego
});

function startNewGame() {
    const theme = document.getElementById('theme').value;
    words = themes[theme];
    wordGrid = generateEmptyGrid(gridSize);
    currentSelection = [];
    wordsFound = [];
    placeWordsInGrid(words, wordGrid);
    renderGrid(wordGrid);
    renderWordsList(words);
    startTimer();
    document.getElementById('settingsModal').style.display = 'none';
}

function generateEmptyGrid(size) {
    return Array(size).fill(null).map(() => Array(size).fill('_'));
}

function placeWordsInGrid(words, grid) {
    words.forEach(word => {
        let placed = false;
        while (!placed) {
            const row = Math.floor(Math.random() * gridSize);
            const col = Math.floor(Math.random() * (gridSize - word.length));
            if (canPlaceWordAt(word, grid, row, col)) {
                for (let i = 0; i < word.length; i++) {
                    grid[row][col + i] = word[i];
                }
                placed = true;
            }
        }
    });
}

function canPlaceWordAt(word, grid, row, col) {
    for (let i = 0; i < word.length; i++) {
        if (grid[row][col + i] !== '_') return false;
    }
    return true;
}

function renderGrid(grid) {
    const container = document.getElementById('wordSearchContainer');
    container.innerHTML = '';
    grid.forEach((row, rowIndex) => {
        row.forEach((cell, colIndex) => {
            const cellElement = document.createElement('div');
            cellElement.textContent = cell === '_' ? String.fromCharCode(65 + Math.floor(Math.random() * 26)) : cell;
            cellElement.dataset.index = rowIndex * gridSize + colIndex;
            cellElement.addEventListener('click', () => selectCell(rowIndex, colIndex, cellElement));
            container.appendChild(cellElement);
        });
    });
}

function renderWordsList(words) {
    const wordsListContainer = document.getElementById('wordsList');
    wordsListContainer.innerHTML = '';
    words.forEach(word => {
        const wordElement = document.createElement('div');
        wordElement.textContent = word;
        wordElement.setAttribute('data-word', word);
        wordsListContainer.appendChild(wordElement);
    });
}

function selectCell(rowIndex, colIndex, cellElement) {
    const index = rowIndex * gridSize + colIndex;
    if (currentSelection.includes(index)) return;
    cellElement.classList.add('selected');
    currentSelection.push(index);
    
    const selectedWord = currentSelection.map(idx => {
        const row = Math.floor(idx / gridSize);
        const col = idx % gridSize;
        return wordGrid[row][col];
    }).join('');

    if (words.includes(selectedWord) && !wordsFound.includes(selectedWord)) {
        wordsFound.push(selectedWord);
        currentSelection.forEach(idx => {
            document.querySelector(`[data-index="${idx}"]`).classList.add('found');
        });

        document.querySelector(`[data-word="${selectedWord}"]`).classList.add('found');
        currentSelection = [];

        if (wordsFound.length === words.length) {
            clearInterval(timerInterval);
            const totalTime = ((Date.now() - startTime) / 1000).toFixed(2);
            document.getElementById('winMessage').textContent = `¡Felicidades! Ganaste en ${totalTime} segundos.`;
            document.getElementById('winModal').style.display = 'flex'; // Mostrar el modal de victoria
        }
    } else if (!words.some(word => word.startsWith(selectedWord))) {
        currentSelection.forEach(idx => {
            document.querySelector(`[data-index="${idx}"]`).classList.remove('selected');
        });
        currentSelection = [];
    }
}

function startTimer() {
    startTime = Date.now();
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(() => {
        const elapsedTime = ((Date.now() - startTime) / 1000).toFixed(2);
        document.getElementById('timer').textContent = `Tiempo: ${elapsedTime}s`;
    }, 100);
}

function closeWinModal() {
    document.getElementById('winModal').style.display = 'none';
}
