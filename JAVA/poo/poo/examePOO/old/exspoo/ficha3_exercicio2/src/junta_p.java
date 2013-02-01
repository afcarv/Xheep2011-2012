import java.util.StringTokenizer;

public class junta_p {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
				
		System.out.print("introduza uma string: ");
		String s = User.readString();
		
		String ultima = "";
		
		for (int i=0; i<s.length()-1; i++){
			ultima += s.charAt(i);
			
			if (vogal(s.charAt(i)) && vogal(s.charAt(i+1))){
				ultima += "p";
			}
		}
		ultima += (s.charAt(s.length()-1));
	
		System.out.print("modified string: "+ultima);
	}
	
	public static boolean vogal(char letra){
		if (letra=='a' || letra=='e' || letra=='i' || letra=='o' || letra=='u')
			return true;
		return false;
		}
	
	}