function createData(myData){
    var finalData = [];

    for (let i=0; i < myData.length; i++){
        if (i % 2 == 0){
            finalData.push(myData[i]);
        }
    }
    return (finalData);
}

function createLabels(myData){
    var finalData = [];
    for (let i=0; i < myData.length; i++){
        if (i % 2 != 0){
            finalData.push(myData[i]);
        }
    }
    return (finalData);
}