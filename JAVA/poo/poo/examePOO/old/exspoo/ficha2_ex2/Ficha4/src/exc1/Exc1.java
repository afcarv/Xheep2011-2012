package exc1;

import common.User;


public class Exc1 {
	public static void main(String[] args){
		Angulo a;
		Angulo b;
		Angulo ab;
		double x;
		
		System.out.print("Primeiro angulo: ");
		x = User.readDouble();
		a = new Angulo(x);
		
		System.out.print("Segundo angulo: ");
		x = User.readDouble();
		b = new Angulo(x);
		
		ab = a.adicao(b);
		
		System.out.println("");
		System.out.println("Primeiro " + a.toString());
		System.out.print("Segundo " + b.toString());
		
		System.out.println("");
		System.out.println("A soma dos dois angulos e " + ab.graus);
		
		System.out.println("");
		System.out.println("O seno da soma dos dois angulos e " + ab.sin());
		
		System.out.println("");
		System.out.println("O coseno da soma dos dois angulos e " + ab.cos());
		
		System.out.println("");
		System.out.println("A tangente da soma dos dois angulos e " + ab.tg());
	}
}


