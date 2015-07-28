window.soundCloud = {
    'client_id': '1fa026842e083e9a1e2821fd1808b204',
    'redirect_uri': 'http://gospel-center.org',
    'lausanne_id': '52004530',
    'montreux_id': '14516848',
    'jura_id': '119056878',
    'annecy_id': '54350620'
};

window.selectList = [{
    'name': 'speakerSearch',
    'text': []
}, {
    'name': 'soundCloudSearch',
    'text': []
}];



$(document).ready(function () {

    SC.initialize({
        client_id: soundCloud.client_id,
        redirect_uri: soundCloud.redirect_uri
    });

    getSoundCloudCList("gospelcenter_celebrationbundle_celebration_audio_ownerId");

    getSpeakerList("gospelcenter_celebrationbundle_celebration_existingSpeakers");

    $("#soundCloudSearch").on('click', "ul li.item", function () {

        selectItemSelectList(this);

    });

    $("#speakerSearch").on('click', "ul li.item", function () {

        selectItemSelectMultipleList(this);

    });

});


/**
 * getSCPlaylistId
 * @returns {string}
 */
function getSCPlaylistId() {

    var center = $("#soundCloudSearch").attr("data-center");

    if (center == 'lausanne') {
        return soundCloud.lausanne_id;
    }

    if (center == 'montreux') {
        return soundCloud.montreux_id;
    }

    if (center == 'jura') {
        return soundCloud.jura_id;
    }

    if (center == 'annecy') {
        return soundCloud.annecy_id;
    }

}


/**
 * getSpeakerList
 */
function getSpeakerList(input_id) {

    var url = "/api/speakers.json";



    $.ajax({
        type: "GET",
        url: url,
        async: true,
        jsonpCallback: 'callback',
        contentType: "application/json",
        dataType: 'json',
        'timeout': 1000,
        error: function () {
            console.log("error");
        },
        success: function (data) {
            var speakers = [];

            $(data).each(function () {
                var speaker = {};

                speaker.id = this.id;
                speaker.title = this.firstname + " " + this.lastname;
                speaker.subTitle = "";
                speaker.image_url = this.image_url;
                speaker.isImage = false;

                if (speaker.image_url) {
                    speaker.isImage = true;
                }


                speakers.push(speaker);
            });

            printSelectList($("#speakerSearch"), speakers, input_id);

            setSpeakerList(speakers);

        }
    });
}


/**
 * getSCList
 */
function getSoundCloudCList(input_id) {

    var url = "https://api.soundcloud.com/playlists/" + getSCPlaylistId() + ".json?client_id=" + soundCloud.client_id;


    SC.get("/playlists/" + getSCPlaylistId() + "/tracks", function(tracks){

        var audios = [];

        tracks.reverse();

        $(tracks).each(function () {
            var audio = {};

            audio.id = this.id;
            audio.title = this.title;
            audio.subTitle = $.format.date(new Date(this.created_at), "dd MMMM yyyy");
            audio.image_url = this.artwork_url;
            audio.isImage = false;
            audio.tags = this.tag_list;
            audio.description = this.description;

            if (audio.image_url) {
                audio.isImage = true;
            }


            audios.push(audio);
        });

        printSelectList($("#soundCloudSearch"), audios, input_id);

        setSoundCloudCList(audios);

    });
}


/**
 * setSCList
 * @param audios
 */
function setSoundCloudCList(audios) {

    $(audios).each(function () {

        if (this.tags != null) {
            var tags = this.tags;
        } else {
            var tags = "";
        }

        if (this.title != null) {
            var title = this.title;
        } else {
            var title = "";
        }

        if (this.description != null) {
            var description = this.description;
        } else {
            var description = "";
        }

        this.text = stringToText(tags + " " + title + " " + description);

        addItemSelectList("soundCloudSearch", this);
    });

}


/**
 * setSpeakerList
 * @param speakers
 */
function setSpeakerList(speakers) {

    $(speakers).each(function () {

        if (this.title != null) {
            var title = this.title;
        } else {
            var title = "";
        }

        if (this.subTitle != null) {
            var subTitle = this.subTitle;
        } else {
            var subTitle = "";
        }

        this.text = stringToText(title + " " + subTitle);

        addItemSelectList("speakerSearch", this);

    });

}

