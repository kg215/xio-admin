
export default function Pager(total,pageSize,pageIndex=0) {
    if(new.target===undefined){
        return new Pager(total,pageSize,pageIndex);
    }
    this._totalPage = Math.ceil(total/pageSize);
    this._pageIndex = pageIndex;
    this._total = total;
}
Pager.prototype.total=function(){
    return this._total;
};
Pager.prototype.totalPage=function(){
    return this._totalPage;
};
Pager.prototype.current=function(){
    return Math.min(this._pageIndex,this._totalPage);
};
