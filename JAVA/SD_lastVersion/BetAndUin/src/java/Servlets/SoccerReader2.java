/*
/**
 * @author afcarv
 * @author jlnabais
 *
 */
package Servlets;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Vector;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathConstants;
import javax.xml.xpath.XPathExpressionException;
import javax.xml.xpath.XPathFactory;

import Objects.New;
import java.util.ArrayList;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;


public class SoccerReader2 {

	private String API_KEY;
	private static Vector<String> ids;
	private static Vector<New> news;
        static ArrayList<String> not;
        static ArrayList<New> not2;


	public SoccerReader2() {

	API_KEY = "dnpzsjyxhm9qdxxusgrgmft5";
        ids = new Vector<String>();
        news = new Vector<New>();
        not = new ArrayList<String>();
        not2 = new ArrayList<New>();

	}

        public static ArrayList<New> getGuardian2(String key, String section) {
		SoccerReader2 reader = new SoccerReader2();

		// First we print the main headlines
		//System.out.println("Headlines:");
        //System.out.println("==========");
		reader.latestHeadlines(key, section);

		// Then we print the main body of the first.
		//System.out.println("\nMore Info:");
		//System.out.println("==========");

		for(int i=0; i<ids.size();i++)
		{
			reader.recentBody(ids.get(i));
		}

		// Print all news info
//		for(int i=0; i<news.size();i++)
//		{
//			New n = news.get(i);
//			System.out.println("");
//			System.out.println("Headline: " + n.getHeadline());
//			System.out.println("Trail-text: " + n.getTrail_text());
//			System.out.println("Body: " + n.getBody());
//			System.out.println("Thumbnail: " + n.getThumbnail());
//			System.out.println("");
//		}
//
//		System.out.println("NUMBER NEWS: " + news.size());

		return not2;
	}

	public static Vector<New> getGuardian(String key, String section) {
		SoccerReader2 reader = new SoccerReader2();

		// First we print the main headlines
		//System.out.println("Headlines:");
        //System.out.println("==========");
		reader.latestHeadlines(key, section);

		// Then we print the main body of the first.
		//System.out.println("\nMore Info:");
		//System.out.println("==========");

		for(int i=0; i<ids.size();i++)
		{
			reader.recentBody(ids.get(i));
		}

		// Print all news info
//		for(int i=0; i<news.size();i++)
//		{
//			New n = news.get(i);
//			System.out.println("");
//			System.out.println("Headline: " + n.getHeadline());
//			System.out.println("Trail-text: " + n.getTrail_text());
//			System.out.println("Body: " + n.getBody());
//			System.out.println("Thumbnail: " + n.getThumbnail());
//			System.out.println("");
//		}
//
//		System.out.println("NUMBER NEWS: " + news.size());

		return news;
	}


	private void latestHeadlines(String query, String section)
	{
		// Used to store the last ID.
		String lastID = null;

		try
		{
			// Initiate the REST client.
			URL url = new URL("http://content.guardianapis.com/search?q="+query+"&section="+section+"&order-by=newest&format=xml&api-key=" + API_KEY);
	        HttpURLConnection connection = (HttpURLConnection) url.openConnection();

	        // HTTP Verb
	        connection.setRequestMethod("GET");
	        // Get requests data from the server.

	        connection.setDoOutput(true);
	        connection.setInstanceFollowRedirects(false);
	        connection.setRequestProperty("User-agent", "ToDo Manager");

	        // If we get a Redirect or an Error (3xx, 4xx and 5xx)
	        if (connection.getResponseCode() >= 300)
	        	// We want more information about what went wrong.
	        	debug(connection);

	        // Response body from InputStream.
	        InputSource inputSource = new InputSource(connection.getInputStream());

	        // XPath is a way of reading XML files.
	        XPathFactory  factory=XPathFactory.newInstance();
	        XPath xPath=factory.newXPath();

	        // here we are querying the document (much like SQL) for all the todo tags inside todo elements.
	        NodeList nodes = (NodeList) xPath.evaluate("/response/results/content", inputSource, XPathConstants.NODESET);
	        // The last argument defines the type of result we are looking for. Might be NODESEQ for a list of Nodes
	        // or NODE for a single node.

	        // We don't need the connection anymore once we get the nodes.
	        connection.disconnect();

	        // Pretty printing of output
	        for (int i=0;i<nodes.getLength();i++)
	        {
	        	Node node = nodes.item(i);

	        	// Fetching the atributes of the node element
	        	//String title = node.getAttributes().getNamedItem("web-title").getTextContent();
	        	//System.out.println(title);
	 			lastID = node.getAttributes().getNamedItem("id").getTextContent();
	 			ids.add(lastID);
	        }

		} catch(IOException e) {
	    	e.printStackTrace();
	    } catch (XPathExpressionException e) {
			e.printStackTrace();
		}

	}


	private void recentBody(String lastID)
	{
		// This function should print the body of the last news item.
		try
		{
			URL url = new URL("http://content.guardianapis.com/" + lastID + "?format=xml&show-fields=all&order-by=newest&api-key=" + API_KEY);
	        HttpURLConnection connection = (HttpURLConnection) url.openConnection();
	        //System.out.println("URL:" + url);

	        // HTTP Verb
	        connection.setRequestMethod("GET");
	        connection.setDoOutput(true);
	        connection.setInstanceFollowRedirects(false);
	        connection.setRequestProperty("User-agent", "ToDo Manager");

			// If we get a Redirect or an Error (3xx, 4xx and 5xx)
	        if (connection.getResponseCode() >= 300)
	        	// We want more information about what went wrong.
	        	debug(connection);

	        // Response body from InputStream.
	        InputSource inputSource = new InputSource(connection.getInputStream());

	        // XPath is a way of reading XML files.
	        XPathFactory  factory=XPathFactory.newInstance();
	        XPath xPath=factory.newXPath();

			NodeList nodes = (NodeList) xPath.evaluate("/response/content/fields/field", inputSource, XPathConstants.NODESET);

        	New n = new New();
                String td = "";

			for (int i=0;i<nodes.getLength();i++)
			{
				Node node = nodes.item(i);

	        	// Fetching the atributes of the node element
	        	String names = node.getAttributes().getNamedItem("name").getTextContent();
	        	String info = node.getTextContent();
	        	//System.out.println(names + " -> " + info);

	        	// names -> headline, trail-text, body, has-story-package, short-url, standfirst, thumbnail, commentable, byline, live-blogging-now, publication

	        	if(names.equals("headline"))
	        		n.setHeadline(info);

	        }
                not2.add(n);
                not.add(td);
	        news.add(n);

		} catch(IOException e) {
	    	e.printStackTrace();
	    } catch (XPathExpressionException e) {
			e.printStackTrace();
		}

	}


	private void debug(HttpURLConnection connection) throws IOException
	{
		// This function is used to debug the resulting code from HTTP connections.

		// Response code such as 404 or 500 will give you an idea of what is wrong.
		System.out.println("Response Code:" + connection.getResponseCode());

		// The HTTP headers returned from the server
		System.out.println("_____ HEADERS _____");

		for ( String header : connection.getHeaderFields().keySet()) {
			System.out.println(header + ": " + connection.getHeaderField(header));
		}

		// If there is an error, the response body is available through the method
		// getErrorStream, instead of regular getInputStream.
        BufferedReader in = new BufferedReader(new InputStreamReader(connection.getErrorStream()));
        StringBuilder builder = new StringBuilder();
        String inputLine;

        while ((inputLine = in.readLine()) != null)
        	builder.append(inputLine);

        in.close();
        System.out.println("Body: " + builder);
	}
}