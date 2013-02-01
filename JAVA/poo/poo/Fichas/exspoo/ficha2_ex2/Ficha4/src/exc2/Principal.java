package exc2;

import common.User;

public class Principal {
	public static void main (String[] args) {
		Fraccao f1;
		Fraccao f2;
		Fraccao r;
		int n,d;
		String op;
		
		
		System.out.print("Fraccao 1, numerador:");
		n = User.readInt();
		System.out.print("Fraccao 1, denominador:");
		d = User.readInt();
		f1 = new Fraccao(n,d);
		
		System.out.print("Fraccao 2, numerador:");
		n = User.readInt();
		System.out.print("Fraccao 2, denominador:");
		d = User.readInt();
		f2 = new Fraccao(n,d);
		
		System.out.println("");
		System.out.print("Operacao a efectuar: ");
		op = User.readString();
		
		if (op.equals("somar"))
			r = f1.somar(f2);
		else if (op.equals("subtrair"))
			r = f1.subtrair(f2);
		else if (op.equals("multiplicar"))
			r = f1.multiplicar(f2);
		else if (op.equals("dividir"))
			r = f1.dividir(f2);
		else {
			System.out.println("A operacao " + op + " não é suportada.");
			return;
		}
		
		System.out.println("O resultado e "+ r.toString());
	}

}
