mwf.ext.touch.location = new function() 
{
	this.map = [];
    this.lib = 'http://maps.google.com/maps/api/js?sensor=true';

    this.buildMap = function(elementID)
    {
        this.map[elementID] = new function()
        {
            this.element = elementID;
            this.map = null;
            this.info = null;
            this.center = false;
            this.locations = [];

            this.init = function(elementID)
            {
                this.element = elementID;
                this.map = new google.maps.Map(document.getElementById(this.element),
                                               {zoom: 15, mapTypeId: google.maps.MapTypeId.ROADMAP});
                this.info = new google.maps.InfoWindow();
                return this;
            }

            this.addLocations = function(arr)
            {
                if(this.map == null)
                    return false;
                for(var i = 0; i < arr.length; i++)
                    this.addLocation(arr[i].name, arr[i].lat, arr[i].lon);
                return true;
            }

			this.addLocation = function(name, lat, lon, iconURL)
            {
                if(this.map == null)
                    return false;
                var i = this.locations.length;
                this.locations[i] = new google.maps.Marker({position: new google.maps.LatLng(lat, lon), map: this.map, title: this.element+'||'+name, icon: iconURL });
                google.maps.event.addListener(this.locations[i], 'click', function(){
                    mwf.ext.touch.location.map[this.getTitle().split('||')[0]].showInfo(i)});
                return true;
            }

            this.setCenter = function(lat, lon)
            {
                return this.map.setCenter(new google.maps.LatLng(lat, lon));
            }

            this.showInfo = function(i)
            {
                if(this.info == null)
                    return false;
                this.info.setPosition(this.locations[i].getPosition());
                this.info.setContent(this.locations[i].getTitle().split('||')[1]);
                this.info.open(this.map);
                return true;
            }

            this.hideInfo = function()
            {
                if(this.info == null)
                    return false;
                this.info.close();
                return true;
            }
        }
        return this.map[elementID].init(elementID);
    }
}