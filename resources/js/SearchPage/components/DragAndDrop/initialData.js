// *** THE CATEGORY KEYS AND THE 'id' VALUE HAVE TO MATCH EXACTLY
// **** INCLUDING CAPITALISATION! ****

const initialData = {
    categories: {
        cinema: {
            id: 'cinema',
            name: 'Cinema',
            categoryId: 1,
            parentId: 0,
        },
        music: {
            id: 'music',
            name: 'Music',
            categoryId: 2,
            parentId: 0,
        },
        theatre: {
            id: 'theatre',
            name: 'Theatre',
            categoryId: 3,
            parentId: 0,
        },
        action: {
            id: 'action',
            name: 'Action',
            categoryId: 4,
            parent_id: 1,
        },
        adventure: {
            id: 'adventure',
            name: 'Adventure',
            categoryId: 5,
            parent_id: 1,
        },
        animation: {
            id: 'animation',
            name: 'Animation',
            categoryId: 6,
            parent_id: 1,
        },
        biography: {
            id: 'biography',
            name: 'Biography',
            categoryId: 7,
            parent_id: 1,
        },
        comedy: {
            id: 'comedy',
            name: 'Comedy',
            categoryId: 8,
            parent_id: 1,
        },
        rock: {
            id: 'rock',
            name: 'Rock',
            categoryId: 9,
            parent_id: 2,
        },
        disco: {
            id: 'disco',
            name: 'Disco',
            categoryId: 10,
            parent_id: 2,
        },
        musical: {
            id: 'musical',
            name: 'Musical',
            categoryId: 11,
            parent_id: 3,
        },
    },

    //  The columns object holds the columns that are in the system
    columns: {
        // The colunm name/key/id for look-up
        categories: {
            id: 'categories',
            title: 'Categories',
            columnType: 'main',
            categoryId: 0,
            categoryIds: ['cinema', 'music', 'theatre'],
        },

        what2do: {
            id: 'what2do',
            title: 'what2do',
            columnType: 'main',
            categoryId: 0,
            categoryIds: [],
        },
        'cinema-preferences': {
            id: 'cinema-preferences',
            title: 'Cinema Preferences',
            columnType: 'sub',
            categoryId: 0,
            categoryIds: [],
        },
        'music-preferences': {
            id: 'music-preferences',
            title: 'Music Preferences',
            columnType: 'sub',
            categoryId: 0,
            categoryIds: [],
        },
        'theatre-preferences': {
            id: 'theatre-preferences',
            title: 'Theatre Preferences',
            columnType: 'sub',
            categoryId: 0,
            categoryIds: [],
        },
        'cinema-sub-categories': {
            id: 'cinema-sub-categories',
            title: 'Cinema sub-categories',
            columnType: 'sub',

            categoryId: 1,
            categoryIds: [
                'action',
                'adventure',
                'animation',
                'biography',
                'comedy',
            ],
        },
        'music-sub-categories': {
            id: 'music-sub-categories',
            title: 'Music sub-categories',
            columnType: 'sub',
            categoryId: 2,
            categoryIds: ['rock', 'disco'],
        },
        'theatre-sub-categories': {
            id: 'theatre-sub-categories',
            title: 'Theatre sub-categories',
            columnType: 'sub',
            categoryId: 3,
            categoryIds: ['musical'],
        },
        'empty-sub-categories': {
            id: 'empty-sub-categories',
            title: 'Instructions:',
            columnType: 'main',
            categoryId: 0,
            categoryIds: [],
        },
    },

    // This facilitates the ordering of the columns
    columnOrder: [
        'categories',
        'what2do',
        'cinema-preferences',
        'music-preferences',
        'theatre-preferences',
        'cinema-sub-categories',
        'music-sub-categories',
        'theatre-sub-categories',
        'empty-sub-categories',
    ],
};

export default initialData;
