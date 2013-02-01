import java.lang.Math;

public class Angulo
{
	double _angle;
	
	Angulo()
	{
		_angle = 0;		
	}
	
	Angulo(double ang)
	{
		_angle = ang;		
	}
	
	String toToString()
	{
		return "angulo de " + _angle + " graus";
	}
	
	/* operations */
	Angulo adicao(Angulo a)
	{		
		return new Angulo(_angle + a._angle);
	}
	
	Angulo subtraccao(Angulo a)
	{
		return new Angulo(_angle - a._angle);
	}
	
	boolean equals(Angulo a)
	{
		return (_angle == a._angle);
	}
	
	/* math */
	double radianos()
	{
		return Math.toRadians(_angle);
	}
	
	double sin()
	{
		return Math.sin(_angle);
	}
	
	double cos()
	{
		return Math.cos(_angle);
	}
	
	double tg()
	{
		return Math.tan(_angle);
	}
}
