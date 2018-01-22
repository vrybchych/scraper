#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int input(char *s,int length);

int find_save(char *s)
{
	int i = 0;

	while(s[i])
	{
		if (s[i] == 's' && s[i+1] == 'a' && s[i+2] == 'v' && s[i+3] == 'e')
			return(i);
		i++;
	}
	return (0);
}

int main()
{
	char	b[4096];
	char	*buffer = b;
	char	url[4096];
	size_t	bufsize = 4096;
	size_t	characters;
	int	i;
	int	j;

	while(getline(&buffer, &bufsize, stdin) != -1)
	{
		if (buffer[0] == '-' && buffer[1] == '-')
		{
			strcpy(url, buffer + 25);
			//printf("URL: %s", buffer + 25);
		}
		if (strstr(buffer, "saved"))
		{
			j = 0;
			while (buffer[j] != ')')
			    j++;
			j += 5;
               		i = find_save(buffer + j) + j;
                	buffer[i - 2] = '\0';
                	printf("URL: %s", url);
                	printf("SAVED: %s\n", buffer + j);
		}		
	}

    return(0);
}
