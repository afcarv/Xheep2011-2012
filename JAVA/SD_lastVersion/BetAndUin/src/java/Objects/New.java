/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
package Objects;

import java.io.Serializable;

public class New implements Serializable {

    private String headline;
    private String traiText;
    private String body;
    private String thumbnail;

    public New(){

    }

    public New( String headline, String traiText, String body, String thumbnail) {
        this.headline=headline;
        this.traiText = traiText;
        this.body = body;
        this.thumbnail = thumbnail;
    }


    public String getBody() {
        return body;
    }

    public void setBody(String body) {
        this.body = body;
    }

    public String getHeadline() {
        return headline;
    }

    public void setHeadline(String headline) {
        this.headline = headline;
    }

    public String getThumbnail() {
        return thumbnail;
    }

    public void setThumbnail(String thumbnail) {
        this.thumbnail = thumbnail;
    }



    public String getTrail_Text() {
        return traiText;
    }

    public void setTrail_text(String traiText) {
        this.traiText = traiText;
    }

}
