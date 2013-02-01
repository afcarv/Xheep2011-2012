package exc1;
import java.lang.Math;

public class Angulo {
	public double graus;
	private double pi = 3.14;
	
	public Angulo () {
		graus = 0;
	}
	public Angulo(double x) {
		graus = x;
	}
	
	public Angulo adicao (Angulo a2) {
		Angulo res = new Angulo (graus + a2.graus);
		return res;
	}
	
	public Angulo subtraccao (Angulo a2) {
		Angulo res = new Angulo (graus - a2.graus);
		return res;
	}
	
	public double radianos() {
		return (graus * pi)/180;
	}
	
	public boolean equals (Angulo a2) {
		if (graus == a2.graus)
			return true;
		else
			return false;
	}
	
	public double sin() {
		return Math.sin(this.radianos());
	}

	public double cos() {
		return Math.cos(this.radianos());
	}

	public double tg() {
		return Math.tan(this.radianos());
	}

	public String toString() {
		String s1 = "angulo de ";
		String n = String.valueOf(graus);
		String s2 = " graus";
		
		return s1 + n + s2;
	}

}















