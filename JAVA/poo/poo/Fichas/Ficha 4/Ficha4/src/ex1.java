
public class ex1 {
	public static void main(String[]args)
	{	
		System.out.println("Insira um valor para o ângulo a");
		Angulo a = new Angulo(User.readDouble());
		
		System.out.println("Insira um valor para o ângulo b");
		Angulo b = new Angulo(User.readDouble());
		
		
		System.out.println("a Soma = " + a.adicao(b).toToString());
		System.out.println("Os senos = " + a.sin() +", " + b.sin());
		System.out.println("Os cosenos = " + a.cos() +", " + b.cos());
		System.out.println("As Tangente da soma = " + (a.tg() + b.tg()));
	}
}
