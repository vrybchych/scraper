#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include <pthread.h>

#define	NTHREADS 20

void	*thread_func(void *args)
{
    system ("php get_domains_and_run.php");
}
/*
void    *thread_php_func(void *args)
{
    system ("php start_get_links_file.php");
}
*/

int	main(int argc, char **argv)
{
    pthread_t	threads[NTHREADS];
    int		count;
/*
    if (pthread_create(&threads[0], NULL, thread_php_func, NULL) != 0)
        fprintf(stderr, "error: Cannot create thread # %d\n", count);
*/
    for (count = 0; count < NTHREADS; ++count)
    {
      if (pthread_create(&threads[count], NULL, thread_func, NULL) != 0)
        {
          fprintf(stderr, "error: Cannot create thread # %d\n", count);
          break;
        }
    }
    for (int i = 0; i < count; ++i)
    {
      if (pthread_join(threads[i], NULL) != 0)
        {
          fprintf(stderr, "error: Cannot join thread # %d\n", i);
        }
    }

    return (0);
}
