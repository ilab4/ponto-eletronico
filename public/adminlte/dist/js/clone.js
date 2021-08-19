$(document).ready( function() {
  
    var regex = /^(.+?)(\d+)$/i;
    var cloneIndex = $(".box_resposta").length;

    function clone(){
        $(this).parents(".box_resposta").clone()
            .appendTo("#resposta")
            .attr("id", "box_resposta" +  cloneIndex)
            .find("*")
            .each(function() {
                var id = this.id || "";
                var match = id.match(regex) || [];
                if (match.length == 3) {
                    this.id = match[1] + (cloneIndex);
                }
            })
            .on('click', 'button.clone', clone)
            .on('click', 'button.remove', remove);
    
        cloneIndex++;
        
        
        
        return false;
        
        
    }
    function remove(){
        $(this).parents(".box_resposta").remove();
        return false;
    }
    $("button.clone").on("click", clone);

    $("button.remove").on("click", remove);
    
    
})