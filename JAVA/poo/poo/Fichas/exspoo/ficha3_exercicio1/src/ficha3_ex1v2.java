
public class ficha3_ex1v2 {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		String mais;
		
		System.out.print("introduza uma string: ");
		mais = User.readString();
		ficha3_ex1v2 e = new ficha3_ex1v2(); //tem de ter o nome da classe
		System.out.println(e.souPalindromo(mais));
	
	}

	public String souPalindromo(String mais) {
		for (int i=0,j=mais.length()-1;i<j; i++, j--){
			if (mais.charAt(i) != mais.charAt(j)){
				return "nao e palindromo";
				}
			}
		return "e palindromo";
	}
}