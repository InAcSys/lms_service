using LMSService.Application.Services.Interfaces;
using LMSService.Domain.DTOs.Course;
using LMSService.Domain.Entities.Concretes;
using LMSService.Infrastructure.Repositories.Interfaces;

namespace LMSService.Application.Services.Abstracts
{
    public abstract class AbstractCourseService(
        ICourseRepository courseRepository
    ) : ICourseService
    {
        protected readonly ICourseRepository _courseRepository = courseRepository;

        public async Task<Course> Create(CreateCourseDTO entity)
        {
            var course = await _courseRepository.Create(entity);
            if (course is null)
            {
                throw new ArgumentException("Course not created!");
            }
            return course;
        }

        public Task<bool> Delete(int id)
        {
            throw new NotImplementedException();
        }

        public async Task<IEnumerable<Course>> GetAll(int pageNumber, int pageSize)
        {
            var courses =  await _courseRepository.GetAll(pageNumber, pageSize);

            return courses;
        }

        public Task<Course?> GetById(int id)
        {
            throw new NotImplementedException();
        }

        public async Task<IEnumerable<Course>> GetUserCoursesById(int id, int pageNumber, int pageSize)
        {
            var courses = await _courseRepository.GetUserCoursesById(id, pageNumber, pageSize);
            return courses;
        }

        public Task<Course> Update(int id, Course entity)
        {
            throw new NotImplementedException();
        }
    }
}
