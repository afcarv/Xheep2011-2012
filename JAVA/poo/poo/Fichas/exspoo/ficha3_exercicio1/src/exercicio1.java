
public class exercicio1 {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		String mais;
		
		System.out.print("introduza uma string: ");
		mais = User.readString();
		
		for (int i=0,j=mais.length()-1;i<j; i++, j--){
			if (mais.charAt(i) != mais.charAt(j)){
				System.out.println("nao e palindromo");
				return;
			}
		}
		System.out.println("e palindromo");
	
	}
}