var merge = function(obj1, obj2) {
    var ret = obj1;

    for(index in obj2) {
        ret[index] = obj2[index];    
    }

    return ret;
};

var overwrite = function(obj1, obj2) {
    var ret = obj1;

    for(index in obj2) {
        if(obj1[index]!=='undefined')
            obj1[index]=obj2[index];
    }

    return ret;
};
