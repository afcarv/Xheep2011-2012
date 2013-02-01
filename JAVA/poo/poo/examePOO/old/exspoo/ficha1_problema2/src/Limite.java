
public class Limite {

	public static void main(String[] args) {
	int limite,soma=0,i=0;
	System.out.print ("Escreva o limite: ");
	limite = User.readInt();
	while(soma<limite){
	i++;
	soma+=i;
	}
	System.out.println("soma ="+soma+"parou em = "+i);
	/*System.out.print("parou em = "+i);*/
}

}