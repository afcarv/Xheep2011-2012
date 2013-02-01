
public class ficha3_ex1v3 {
	
	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		String mais;
		
		System.out.print("introduza uma string: ");
		mais = User.readString();
		System.out.println (souPalindromo(mais));
	
	}

	public static String souPalindromo(String mais) {
	for (int i=0,j=mais.length()-1;i<j; i++, j--){
		if (mais.charAt(i) != mais.charAt(j)){
			return "nao e palindromo";
		}
	}
	return "e palindromo";
  }
}
